<?php

namespace Hal\ReleaseBundle\Specification;

use Hal\ReleaseBundle\Entity\ReleaseInterface;

interface ConstraintSpecificationInterface
{

    public function isSatisfiedBy(ReleaseInterface $version);
}
