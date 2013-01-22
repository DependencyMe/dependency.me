<?php
namespace Hal\GithubBundle\Repository;
use Hal\GithubBundle\Entity\AuthentifiableInterface;
use Hal\GithubBundle\Entity\Owner;
use Hal\GithubBundle\Entity\OwnerInterface;
use Hal\GithubBundle\Entity\Repository;
use Doctrine\ORM\EntityManager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Hal\GithubBundle\Event\GithubEvent;
use Hal\GithubBundle\Event\QueryEvent;

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


    public function getByName($name)
    {
        if (!preg_match('!(.*)/(.*)!', $name, $matches)) {
            throw new \UnexpectedValueException("$name must contains the name of the owner (owner/name)");
        }

        list(, $username, $reponame) = $matches;

        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
            ->select('o, r, b')
            ->from('HalGithubBundle:Repository', 'r')
            ->join('r.owner', 'o')
            ->join('r.branches', 'b')
            ->where('r.name = :name')
            ->andWhere('o.login = :login');

        // call listeners
        $event = new QueryEvent($queryBuilder);
        $this->eventDispatcher->dispatch(GithubEvent::PREPARE_QUERY_REPOSITORY, $event);

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


        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
            ->select('o, r, b')
            ->from('HalGithubBundle:Repository', 'r')
            ->join('r.owner', 'o')
            ->leftJoin('r.branches', 'b')
            ->where('r.enabled = 1');

        // call listeners
        $event = new QueryEvent($queryBuilder);
        $this->eventDispatcher->dispatch(GithubEvent::PREPARE_QUERY_REPOSITORY, $event);


        if (preg_match('!(.*)/(.*)!', $expression, $matches)) {
            list(, $user, $repo) = $matches;
            $queryBuilder
                ->andWhere('o.login = :name')
                ->orWhere('r.name = :name');
        } else {
            $queryBuilder->orWhere('r.name = :name');
        }
        $query = $queryBuilder->getQuery();

        $query->setParameter('name', $expression);
        return $query->getResult();

    }
}