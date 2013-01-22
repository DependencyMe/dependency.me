<?php

namespace Hal\Bundle\ReleaseBundle\Service;

use Hal\Bundle\ReleaseBundle\Entity\Package;

interface PackageServiceInterface
{
    public function getOrCreateByName($name);

}
