<?php
namespace Hal\Bundle\GithubBundle\Repository;
use Hal\Bundle\GithubBundle\Entity\Owner;
use Hal\Bundle\GithubBundle\Entity\OwnerInterface;
use Hal\Bundle\GithubBundle\Entity\Repository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Hal\Bundle\GithubBundle\Event\GithubEvent;
use Hal\Bundle\GithubBundle\Event\QueryEvent;

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


}