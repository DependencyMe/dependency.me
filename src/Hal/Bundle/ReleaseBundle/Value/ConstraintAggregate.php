<?php

namespace Hal\Bundle\ReleaseBundle\Value;

use Hal\Bundle\ReleaseBundle\Entity\ReleaseInterface;
use Hal\Bundle\ReleaseBundle\Specification\ConstraintSpecificationInterface;
use Hal\Bundle\ReleaseBundle\Value\ConstraintInterface;

class ConstraintAggregate implements ConstraintSpecificationInterface, ConstraintInterface
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

    public function getVersion()
    {
    }

    public function getOperator()
    {
    }

    public function __toString()
    {
        return $this->getPrettyString();
    }

    public function getMinAndMax()
    {
        $min = 999999999;
        $max = 0;
        foreach ($this->constraints as $constraint) {
            $limit = $constraint->getMinAndMax();
            if ($limit->min < $min) {
                $min = $limit->min;
            }
            if ($limit->max > $max) {
                $max = $limit->max;
            }
        }
        return (object)array('min' => $min, 'max' => $max);
    }


}
