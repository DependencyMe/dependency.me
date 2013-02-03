<?php
namespace Hal\Bundle\GithubBundle\Repository;
use Hal\Bundle\GithubBundle\Entity\Owner;
use Doctrine\ORM\EntityManager;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Hal\Bundle\GithubBundle\Event\QueryEvent;
use Hal\Bundle\GithubBundle\Event\GithubEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class OwnerRepository implements OwnerRepositoryInterface
{

    private $em;
    private $eventDispatcher;

    public function __construct(EntityManager $em, EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }


    /**
     * Loads the user by a given UserResponseInterface object.
     *
     * @param UserResponseInterface $response
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function getUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $owner = $this->getUserByAccessToken($response->getAccessToken());

        if (!$owner) {

            $owner = new Owner;
            $owner
                ->setLogin($response->getNickname())
                ->setName($response->getRealName())
                ->setPermanentAccessToken($response->getAccessToken());

            $this->saveOwner($owner);

        }

        return $owner;
    }


    public function getUserByAccessToken($accessToken)
    {

        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
            ->select('o, r, b')
            ->from('HalGithubBundle:Owner', 'o')
            ->leftJoin('o.repositories', 'r')
            ->leftJoin('r.branches', 'b')
            ->where('o.permanentAccessToken = :permanent_access_token');

        // call listeners
        $event = new QueryEvent($queryBuilder);
        $this->eventDispatcher->dispatch(GithubEvent::PREPARE_QUERY_OWNER, $event);

        $query = $queryBuilder->getQuery();
        $query->setParameter('permanent_access_token', $accessToken);
        return $query->getOneOrNullResult();
    }


    public function getOwnerByLogin($login)
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
            ->select('o, r, b')
            ->from('HalGithubBundle:Owner', 'o')
            ->leftJoin('o.repositories', 'r')
            ->leftJoin('r.branches', 'b')
            ->where('o.login = :login')
            ->setMaxResults(1);

        // call listeners
        $event = new QueryEvent($queryBuilder);
        $this->eventDispatcher->dispatch(GithubEvent::PREPARE_QUERY_OWNER, $event);

        $query = $queryBuilder->getQuery();
        $query->setParameter('login', $login);

        return $query->getOneOrNullResult();
    }

    public function listRecentlyUpdated($limit)
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
            ->select('o')
            ->from('HalGithubBundle:Owner', 'o')
            ->orderBy('o.lastUpdate', 'DESC')
            ->setMaxResults($limit);
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    public function saveOwner(Owner $owner)
    {
        $this->em->persist($owner);
        $this->em->flush();
    }
}