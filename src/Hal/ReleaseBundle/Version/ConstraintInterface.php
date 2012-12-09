<?php

namespace Hal\ReleaseBundle\Version;

interface ConstraintInterface
{

    public function getVersion();

    public function getOperator();
}
