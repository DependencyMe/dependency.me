<?php

namespace Hal\ReleaseBundle\Version;

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

}
