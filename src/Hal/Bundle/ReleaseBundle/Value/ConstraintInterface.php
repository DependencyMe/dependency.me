<?php

namespace Hal\Bundle\ReleaseBundle\Value;

interface ConstraintInterface
{

    public function getVersion();

    public function getOperator();

    public function getPrettyString();

    public function getMinAndMax();
}
