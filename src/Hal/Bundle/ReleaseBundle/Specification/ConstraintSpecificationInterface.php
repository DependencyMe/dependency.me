<?php

namespace Hal\Bundle\ReleaseBundle\Specification;

use Hal\Bundle\ReleaseBundle\Entity\ReleaseInterface;

interface ConstraintSpecificationInterface
{

    public function isSatisfiedBy(ReleaseInterface $version);
}
