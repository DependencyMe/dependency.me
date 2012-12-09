<?php

namespace Hal\ReleaseBundle\Release\Version;

use Composer\Package\LinkConstraint\LinkConstraintInterface;

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
                throw new Exception('Constraint type is not supported');
                break;
        }
    }

    public function factoryFromString($constraintString)
    {
        $constraintAggregat = new ConstraintAgregat;
        $split = explode(',', $constraintString);
        $versions = array();
        foreach ($split as $ver) {
            preg_match('!([=><]{0,2})(.*)!', $ver, $matches);

            if (strlen($matches[1]) == 0) {
                $matches[1] = '=';
            }

            $constraint = new Constraint($matches[2], $matches[1]);
            $constraintAggregat->addConstraint($constraint);
        }
        return $constraintAggregat;
    }

    public function factoryFromComposerConstraintLink(LinkConstraintInterface $composerConstraint)
    {
        return $this->factoryFromString($composerConstraint->getPrettyString());
    }

}
