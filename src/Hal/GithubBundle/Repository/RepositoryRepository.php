<?php
namespace Hal\GithubBundle\Repository;
use Hal\GithubBundle\Entity\AuthentifiableInterface;
use Hal\GithubBundle\Entity\Owner;
use Hal\GithubBundle\Entity\OwnerInterface;
use Hal\GithubBundle\Entity\Repository;
use Doctrine\ORM\EntityManager;

class RepositoryRepository implements RepositoryRepositoryInterface
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getByOwner(OwnerInterface $auth)
    {
        $query = $this->em->createQuery("
            SELECT
                r
            FROM
                HalGithubBundle:Repository r
            WHERE
                r.owner = :owner
            ");
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
        $query = $this->em->createQuery("
            SELECT
                r
            FROM
                HalGithubBundle:Repository r
            WHERE
                r.name = :name
            ");
        $query->setParameter('name', $name);
        return $query->getResult();
    }

    public function saveRepository(Repository $repository)
    {
        $this->em->persist($repository);
        $this->em->flush();
    }
}