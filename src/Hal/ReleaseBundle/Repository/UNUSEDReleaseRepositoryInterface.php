<?php

namespace Hal\ReleaseBundle\Repository;
use \Hal\ReleaseBundle\Release\Package\PackageInterface;

interface ReleaseRepositoryInterface
{

    public function findReleases(PackageInterface $package);


}
