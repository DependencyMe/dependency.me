<?php

namespace Hal\ReleaseBundle\Service;

use Hal\ReleaseBundle\Repository\PackageRepositoryInterface;

class PackageService implements PackageServiceInterface
{

    private $repository;

    function __construct(PackageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAvailableReleases(Package $package)
    {
        return $this->repository->findReleases($package);
    }

    public function getMatchingPackages($searchedTerm) {
        return $this->repository->getMatchingPackages($searchedTerm);
    }
}
