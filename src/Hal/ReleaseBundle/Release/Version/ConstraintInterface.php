<?php

namespace Hal\ReleaseBundle\Release\Version;

interface ConstraintInterface
{

    public function getVersion();

    public function getOperator();

    public function getPrettyString();
}
