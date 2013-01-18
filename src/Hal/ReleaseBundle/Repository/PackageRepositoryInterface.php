<?php

namespace Hal\ReleaseBundle\Repository;
use \Hal\ReleaseBundle\Release\Package\PackageInterface;

interface PackageRepositoryInterface
{

    public function getByName($name);

}
