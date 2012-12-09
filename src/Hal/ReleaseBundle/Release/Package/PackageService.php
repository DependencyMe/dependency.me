<?php

namespace Hal\ReleaseBundle\Release\Package;

use Hal\ReleaseBundle\Release\Package\Repository\RepositoryInterface;

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
