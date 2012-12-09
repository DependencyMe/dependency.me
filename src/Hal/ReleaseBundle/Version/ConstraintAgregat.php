<?php

namespace Hal\ReleaseBundle\Version;

use Hal\ReleaseBundle\Version\ReleaseInterface;

class ConstraintAgregat implements SpecificationInterface
{

    private $constraints;

    public function __construct(array $constraints = array())
    {
        $this->constraints = $constraints;
    }

    public function isSatisfedBy(ReleaseInterface $release)
    {
        foreach ($this->constraints as $constraint) {
            if (!$constraint->isSatisfedBy($release)) {
                return false;
            }
        }
        return true;
    }

    public function addConstraint(Constraint $constraint)
    {
        array_push($this->constraints, $constraint);
        return $this;
    }

    public function getConstraints()
    {
        return $this->constraints;
    }

}
