<?php

namespace Hal\Bundle\ReleaseBundle\Repository;

use Hal\Bundle\ReleaseBundle\Entity\Package;

interface PackageRepositoryInterface
{

    public function getByName($name);

    public function savePackage(Package $name);

    public function getInfosOfPackage(Package $name);

    public function getPopulars($limit);
}
