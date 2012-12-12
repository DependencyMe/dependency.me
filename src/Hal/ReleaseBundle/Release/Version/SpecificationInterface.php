<?php

namespace Hal\ReleaseBundle\Release\Version;

use Hal\ReleaseBundle\Release\Version\ReleaseInterface;

interface SpecificationInterface
{

    public function isSatisfiedBy(ReleaseInterface $version);
}
