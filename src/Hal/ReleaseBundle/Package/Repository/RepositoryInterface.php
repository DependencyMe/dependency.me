<?php

namespace Hal\ReleaseBundle\Package\Repository;

interface RepositoryInterface
{

    public function findReleases(\Hal\ReleaseBundle\Package\PackageInterface $package);
}
