<?php

namespace Hal\Bundle\GithubBundle\Repository;

use Hal\Bundle\GithubBundle\Entity\OwnerInterface;
use Hal\Bundle\GithubBundle\Entity\Repository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Hal\Bundle\GithubBundle\Event\GithubEvent;
use Hal\Bundle\GithubBundle\Event\QueryEvent;

class RepositoryRepository implements RepositoryRepositoryInterface
{

    private $em;
    private $eventDispatcher;

    public function __construct(EntityManager $em, EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getByOwner(OwnerInterface $auth)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->where('r.owner = :owner');
        $query = $queryBuilder->getQuery();
        $query->setParameter('owner', $auth);
        return $query->getResult();
    }

    public function removeByOwner(OwnerInterface $owner)
    {
        $repositories = $this->getByOwner($owner);
        foreach ($repositories as $repository) {
            $this->em->remove($repository);
        }
        $this->em->flush();
    }

    public function getRepository($fullname)
    {
        list($login, $name) = explode('/', $fullname);
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
            ->where('o.login = :login')
            ->andWhere('r.name = :name');
        $query = $queryBuilder->getQuery();
        $query->setParameter('login', $login);
        $query->setParameter('name', $name);
        return $query->getOneOrNullResult();
    }

    public function removeRepository(Repository $repository)
    {
        $this->em->remove($repository);
        $this->em->flush();
    }

    public function getByName($name)
    {
        if (!preg_match('!(.*)/(.*)!', $name, $matches)) {
            throw new \UnexpectedValueException("$name must contains the name of the owner (owner/name)");
        }

        list(, $username, $reponame) = $matches;

        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
            ->where('r.name = :name')
            ->andWhere('o.login = :login');

        $query = $queryBuilder->getQuery();
        $query->setParameter('name', $reponame);
        $query->setParameter('login', $username);
        return $query->getOneOrNullResult();
    }

    public function saveRepository(Repository $repository)
    {
        $this->em->persist($repository);
        $this->em->flush();
    }

    public function search($expression)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->where('r.enabled = 1');

        if (preg_match('!(.*)/(.*)!', $expression, $matches)) {
            list(, $user, $repo) = $matches;
            $queryBuilder->andWhere('o.login = :user OR r.name = :repo');
            $query = $queryBuilder->getQuery();
            $query->setParameter('user', $user);
            $query->setParameter('repo', $repo);
        } else {
            $queryBuilder->andWhere('r.name = :name OR o.login = :name');
        }

        $query = $queryBuilder->getQuery();
        $query->setParameter('name', $expression);

        return $query->getResult();
    }

    public function listRecentlyUpdated($limit)
    {
        // we don't want to get branches
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
            ->select('o, r')
            ->from('HalGithubBundle:Repository', 'r')
            ->join('r.owner', 'o')
            ->where('r.enabled = 1')
            ->orderBy('r.lastUpdate', 'DESC')
            ->setMaxResults($limit);
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    private function getQueryBuilder()
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
            ->select('o, r, b')
            ->from('HalGithubBundle:Repository', 'r')
            ->join('r.owner', 'o')
            ->join('r.branches', 'b')
            ->where('r.owner = :owner');

        // call listeners
        $event = new QueryEvent($queryBuilder);
        $this->eventDispatcher->dispatch(GithubEvent::PREPARE_QUERY_REPOSITORY, $event);
        return $queryBuilder;
    }

}