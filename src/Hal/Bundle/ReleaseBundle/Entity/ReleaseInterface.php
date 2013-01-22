<?php

namespace Hal\Bundle\ReleaseBundle\Entity;

interface ReleaseInterface
{

    public function getVersion();

    public function getPrettyString();
}
