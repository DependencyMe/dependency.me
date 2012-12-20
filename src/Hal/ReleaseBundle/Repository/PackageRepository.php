<?php

namespace Hal\ReleaseBundle\Repository;

use Hal\ReleaseBundle\Release\Package\PackageInterface;
use Composer\Repository\RepositoryInterface as ComposerRepositoryInterface;

use Hal\ReleaseBundle\Release\Version\Release;
use Doctrine\ORM\EntityManager;

class PackageRepository implements PackageRepositoryInterface
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getMatchingPackages($searchedTerm)
    {
        $query = $this->em->createQuery("
            SELECT
                p
            FROM
                HalReleaseBundle:Package p
            JOIN
                HalReleaseBundle:Owner o
            WHERE
                p.name LIKE :word
                OR o.name LIKE :word
            ");
        $query->setParameter('word', '%'.$searchedTerm.'%');
        return $query->getResult();
    }
}
