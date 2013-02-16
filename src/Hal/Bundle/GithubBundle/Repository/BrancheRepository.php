<?php

namespace Hal\Bundle\GithubBundle\Repository;

use Doctrine\ORM\EntityManager;
use Hal\Bundle\GithubBundle\Entity\Branche;
use Hal\Bundle\GithubBundle\Event\GithubEvent;
use Hal\Bundle\GithubBundle\Event\QueryEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BrancheRepository implements BrancheRepositoryInterface
{

    private $em;
    private $eventDispatcher;

    public function __construct(EntityManager $em, EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getByFullName($name)
    {
        if (!\preg_match('!^([\\w\-\d]*)/([\\w\-\d]*)/(.*)!', $name, $matches)) {
            return null;
        }
        list(, $user, $repository, $branche) = $matches;

        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
                ->select('o, r, b')
                ->from('HalGithubBundle:Branche', 'b')
                ->leftJoin('b.repository', 'r')
                ->leftJoin('r.owner', 'o')
                ->where('o.login = :username')
                ->andWhere('r.name = :repository')
                ->andWhere('b.name = :branche')
        ;
        // call listeners
        $event = new QueryEvent($queryBuilder);
        $this->eventDispatcher->dispatch(GithubEvent::PREPARE_QUERY_BRANCHE, $event);


        $query = $queryBuilder->getQuery();
        $query->setParameter('branche', $branche);
        $query->setParameter('username', $user);
        $query->setParameter('repository', $repository);
        return $query->getOneOrNullResult();
    }

    public function saveBranche(Branche $branche)
    {
        $this->em->persist($branche);
        $this->em->flush();
    }

}