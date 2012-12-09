<?php

namespace Hal\ReleaseBundle\Package;

use Hal\ReleaseBundle\Package\Repository\RepositoryInterface;

class PackageService
{

    private $repository;

    function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAvailableReleases(Package $package)
    {
        return $this->repository->findReleases($package);
    }

}
