<?php

namespace Hal\ReleaseBundle\Service;

use Hal\ReleaseBundle\Entity\Package;

interface PackageServiceInterface
{
    public function getOrCreateByName($name);

}
