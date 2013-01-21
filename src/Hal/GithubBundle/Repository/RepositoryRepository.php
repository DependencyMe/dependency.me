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
                r, o, b, d, req
            FROM
                HalGithubBundle:Repository r
            JOIN
                r.owner o
            JOIN
                r.branches b
            LEFT JOIN
                b.declaration d
            LEFT JOIN
                d.requirements req
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
        if (!preg_match('!(.*)/(.*)!', $name, $matches)) {
            throw new \UnexpectedValueException("$name must contains the name of the owner (owner/name)");
        }

        list(, $username, $reponame) = $matches;

        $query = $this->em->createQuery("
            SELECT
                r, o, b, d, req
            FROM
                HalGithubBundle:Repository r
            JOIN
                r.owner o
            JOIN
                r.branches b
            LEFT JOIN
                b.declaration d
            LEFT JOIN
                d.requirements req
            WHERE
                r.name = :name
                and o.login = :login
            ");
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
        if (preg_match('!(.*)/(.*)!', $expression, $matches)) {


            list(, $username, $reponame) = $matches;
            $query = $this->em->createQuery("
            SELECT
                r, o, b, d, req
            FROM
                HalGithubBundle:Repository r
            JOIN
                r.owner o
            JOIN
                r.branches b
            LEFT JOIN
                b.declaration d
            LEFT JOIN
                d.requirements req
            WHERE
                r.name = :name
                and o.login = :login
                And r.enabled = 1
            ");
            $query->setParameter('name', $reponame);
            $query->setParameter('login', $username);


        } else {


            $query = $this->em->createQuery("
            SELECT
                r, o, b, d, req
            FROM
                HalGithubBundle:Repository r
            JOIN
                r.owner o
            JOIN
                r.branches b
            LEFT JOIN
                b.declaration d
            LEFT JOIN
                d.requirements req
            WHERE
                (r.name = :name
                or o.login = :name)
                And r.enabled = 1
            ");
            $query->setParameter('name', $expression);


        }
        return $query->getResult();

    }
}