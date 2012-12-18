<?php

namespace Hal\ReleaseBundle\Release\Package\Repository;
use \Hal\ReleaseBundle\Release\Package\PackageInterface;

interface ReleaseRepositoryInterface
{

    public function findReleases(PackageInterface $package);


}
