<?php

namespace Hal\ReleaseBundle\Entity;

interface ReleaseInterface
{

    public function getVersion();

    public function getPrettyString();
}
