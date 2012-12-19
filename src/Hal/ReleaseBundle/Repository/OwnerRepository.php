<?php
namespace Hal\ReleaseBundle\Repository;
use \Hal\GithubBundle\Entity\AuthentifiableInterface;
use Doctrine\ORM\EntityManager;
class OwnerService implements OwnerServiceInterface
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
                o.token = :token
            ");
        $query->setParameter('token', $auth->getPermanentAccessToken());
        return $query->getResult();
    }
}