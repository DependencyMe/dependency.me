<?php

namespace Hal\ReleaseBundle\Service;

use Hal\ReleaseBundle\Repository\PackageRepositoryInterface;

interface PackageServiceInterface
{
    public function getAvailableReleases(Package $package);

    public function getMatchingPackages($searchedTerm) ;
}
