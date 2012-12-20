<?php

namespace Hal\ReleaseBundle\Entity;

interface ConstraintInterface
{

    public function getVersion();

    public function getOperator();

    public function getPrettyString();
}
