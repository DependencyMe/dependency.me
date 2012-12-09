<?php

namespace Hal\ReleaseBundle\Version;

use Hal\ReleaseBundle\Version\ReleaseInterface;

interface SpecificationInterface
{

    public function isSatisfedBy(ReleaseInterface $version);
}
