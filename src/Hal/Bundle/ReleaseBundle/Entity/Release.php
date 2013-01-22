<?php

namespace Hal\Bundle\ReleaseBundle\Entity;

class Release implements ReleaseInterface
{

    private $version;

    function __construct($version)
    {
        $this->version = $version;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getPrettyString()
    {
        return (string)$this->getVersion();
    }


}
