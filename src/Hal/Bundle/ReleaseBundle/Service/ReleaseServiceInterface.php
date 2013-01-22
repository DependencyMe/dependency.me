<?php

namespace Hal\Bundle\ReleaseBundle\Service;
use Hal\Bundle\ReleaseBundle\Entity\ReleaseInterface;

interface ReleaseServiceInterface
{

    public function getStateOf(ReleaseInterface $releaseToTest, ReleaseInterface $releaseCurrent = null);
}
