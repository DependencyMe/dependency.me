<?php
namespace Hal\GithubBundle\Repository;
use Hal\GithubBundle\Entity\AuthentifiableInterface;
use Hal\GithubBundle\Entity\Owner;
use Hal\GithubBundle\Entity\OwnerInterface;
use Hal\GithubBundle\Entity\Repository;
use Doctrine\ORM\EntityManager;

class BrancheRepository implements BrancheRepositoryInterface
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getByFullName($name)
    {
        if (!\preg_match('!(.*)/(.*)/(.*)!', $name, $matches)) {
            return null;
        }
        list(, $user, $repository, $branche) = $matches;


        $query = $this->em->createQuery("
            SELECT
                b, r, o
            FROM
              HalGithubBundle:Branche b
            JOIN
                b.repository r
            JOIN
                r.owner o
            WHERE
                o.login = :username
                AND r.name = :repository
                AND b.name = :branche
            ");
        $query->setParameter('branche', $branche);
        $query->setParameter('username', $user);
        $query->setParameter('repository', $repository);
        return $query->getOneOrNullResult();
    }


}