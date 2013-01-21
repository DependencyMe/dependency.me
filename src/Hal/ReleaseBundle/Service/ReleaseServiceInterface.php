<?php

namespace Hal\ReleaseBundle\Service;
use Hal\ReleaseBundle\Entity\ReleaseInterface;

interface ReleaseServiceInterface
{

    public function getStateOf(ReleaseInterface $releaseToTest, ReleaseInterface $releaseCurrent);
}
