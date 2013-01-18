<?php

namespace Hal\ReleaseBundle\Factory;

use Composer\Package\LinkConstraint\LinkConstraintInterface;
use Hal\ReleaseBundle\Value\ConstraintAggregate;
use Hal\ReleaseBundle\Value\Constraint;
class ConstraintFactory
{

    public function factory($constraint)
    {
        switch (true) {
            case (is_string($constraint)):
                return $this->factoryFromString($constraint);
                break;
            case ($constraint instanceof LinkConstraintInterface):
                return $this->factoryFromComposerConstraintLink($constraint);
                break;
            default:
                throw new \Exception('Constraint type is not supported');
                break;
        }
    }

    public function factoryFromString($constraintString)
    {
        $constraintAggregate = new ConstraintAggregate;
        $split = explode(',', $constraintString);
        foreach ($split as $ver) {
            preg_match('!([=><]{0,2})(.*)!', $ver, $matches);

            if (strlen($matches[1]) == 0) {
                $matches[1] = '=';
            }

            $constraint = new Constraint($matches[2], $matches[1]);
            $constraintAggregate->addConstraint($constraint);
        }
        return $constraintAggregate;
    }

    public function factoryFromComposerConstraintLink(LinkConstraintInterface $composerConstraint)
    {
        return $this->factoryFromString($composerConstraint->getPrettyString());
    }

}
