<?php

namespace Hal\ReleaseBundle\Repository;
use \Hal\ReleaseBundle\Release\Package\PackageInterface;

interface RepositoryInterface
{

    public function getMatchingPackages($searchedTerm);

}
