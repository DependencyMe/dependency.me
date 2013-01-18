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

    public function getByName($name)
    {
        $query = $this->em->createQuery("
            SELECT
                p
            FROM
                HalReleaseBundle:Package p
            WHERE
                p.name LIKE :name
            ");
        $query->setParameter('name', $name);
        return $query->getOneOrNullResult();
    }
}
