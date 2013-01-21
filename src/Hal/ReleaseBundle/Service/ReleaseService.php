<?php

namespace Hal\ReleaseBundle\Service;
use Hal\ReleaseBundle\Entity\ReleaseInterface;
use Hal\ReleaseBundle\Entity\RequirementInterface;

class ReleaseService implements ReleaseServiceInterface
{

    public function getStateOf(ReleaseInterface $releaseToTest, ReleaseInterface $releaseCurrent)
    {

        $versionToTest = $releaseToTest->getVersion();
        $versionCurrent = $releaseCurrent->getVersion();


        while (substr_count($versionToTest, '.') < 3) {
            $versionToTest .= '.0';
        }

        while (substr_count($versionCurrent, '.') < 3) {
            $versionCurrent .= '.0';
        }

        $partsToTest = explode('.', $versionToTest);
        $partsCurrent = explode('.', $versionCurrent);

        if ($partsToTest[0] < $partsCurrent[0]) {
            return RequirementInterface::STATUS_OUT_OF_DATE;
        }
        if ($versionCurrent === $versionToTest) {
            return RequirementInterface::STATUS_LATEST;
        }
        if ($versionCurrent < $versionToTest) { // using more recent version than the original :)
            return RequirementInterface::STATUS_LATEST;
        }
        return RequirementInterface::STATUS_RECENT;
    }
}
