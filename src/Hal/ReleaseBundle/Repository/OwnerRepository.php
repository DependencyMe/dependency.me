<?php
namespace Hal\ReleaseBundle\Repository;
use \Hal\GithubBundle\Entity\AuthentifiableInterface;
use Doctrine\ORM\EntityManager;
class OwnerRepository implements OwnerRepositoryInterface
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function findOwnerByAuth(AuthentifiableInterface $auth) {
        $query = $this->em->createQuery("
            SELECT
                o
            FROM
                HalReleaseBundle:Owner o
            WHERE
                o.permanentAccessToken = :permanent_access_token
            ");
        $query->setParameter('permanent_access_token', $auth->getPermanentAccessToken());
        return $query->getResult();
    }
}