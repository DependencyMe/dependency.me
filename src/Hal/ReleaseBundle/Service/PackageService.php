<?php

namespace Hal\ReleaseBundle\Service;

use Hal\ReleaseBundle\Repository\PackageRepositoryInterface;
use Hal\ReleaseBundle\Entity\Package;

class PackageService implements PackageServiceInterface
{

    private $repository;

    function __construct(PackageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function getOrCreateByName($name)
    {
        $package = $this->repository->getByName($name);
        if (!$package) {

            $package = new Package();
            $package->setName($name);

            // @todo ordonnanceur

        }

        return $package;
    }
}
