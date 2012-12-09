<?php

namespace Hal\ReleaseBundle\Release\Package\Repository;

interface RepositoryInterface
{

    public function findReleases(\Hal\ReleaseBundle\Release\Package\PackageInterface $package);
}
