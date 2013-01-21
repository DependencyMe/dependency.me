<?php

namespace Hal\ReleaseBundle\Repository;
use Hal\ReleaseBundle\Entity\Package;

interface PackageRepositoryInterface
{

    public function getByName($name);

    public function savePackage(Package $name);

    public function getInfosOfPackage(Package $name);

}
