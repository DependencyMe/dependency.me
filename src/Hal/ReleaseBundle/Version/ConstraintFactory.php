<?php

namespace Hal\ReleaseBundle\Version;

use Composer\Package\LinkConstraint\LinkConstraintInterface;

class ConstraintFactory
{

    public function factory($constraint)
    {
        switch (true) {
            case ($constraint instanceof LinkConstraintInterface):
                return $this->factoryFromComposerConstraintLink($constraint);
                break;
            default:
                throw new Exception('Constraint type is not supported');
                break;
        }
    }

    public function factoryFromComposerConstraintLink(LinkConstraintInterface $composerConstraint)
    {
        $constraintAggregat = new ConstraintAgregat;

        $split = explode(',', $composerConstraint->getPrettyString());
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

}
