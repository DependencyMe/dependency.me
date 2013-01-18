<?php

namespace Hal\ReleaseBundle\Value;

interface ConstraintInterface
{

    public function getVersion();

    public function getOperator();

    public function getPrettyString();
}
