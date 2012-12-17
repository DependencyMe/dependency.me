<?php

namespace Hal\ReleaseBundle\Release\Version;

use Hal\ReleaseBundle\Release\Version\ReleaseInterface;

class ConstraintAggregate implements SpecificationInterface
{

    private $constraints;

    public function __construct(array $constraints = array())
    {
        $this->constraints = $constraints;
    }

    public function isSatisfiedBy(ReleaseInterface $release)
    {
        foreach ($this->constraints as $constraint) {
            if (!$constraint->isSatisfiedBy($release)) {
                return false;
            }
        }
        return true;
    }

    public function addConstraint(ConstraintInterface $constraint)
    {
        array_push($this->constraints, $constraint);
        return $this;
    }

    public function getConstraints()
    {
        return $this->constraints;
    }

    public function getPrettyString()
    {
        $strings = array();
        foreach ($this->getConstraints() as $constraint) {
            array_push($strings, $constraint->getPrettyString());
        }
        return implode(',', $strings);
    }

}
