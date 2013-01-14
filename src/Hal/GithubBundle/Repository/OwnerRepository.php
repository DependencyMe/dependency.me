<?php
namespace Hal\GithubBundle\Repository;
use Hal\GithubBundle\Entity\AuthentifiableInterface;
use Hal\GithubBundle\Entity\Owner;
use Doctrine\ORM\EntityManager;

class OwnerRepository implements OwnerRepositoryInterface
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function findOwnerByAuth(AuthentifiableInterface $auth)
    {
        $query = $this->em->createQuery("
            SELECT
                o
            FROM
                HalGithubBundle:Owner o
            WHERE
                o.permanentAccessToken = :permanent_access_token
            ");
        $query->setParameter('permanent_access_token', $auth->getPermanentAccessToken());
        return $query->getResult();
    }

    public function saveOwner(Owner $owner)
    {
        $this->em->persist($owner);
        $this->em->flush();
    }
}