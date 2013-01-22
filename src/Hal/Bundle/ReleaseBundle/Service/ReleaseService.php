<?php

namespace Hal\Bundle\ReleaseBundle\Service;
use Hal\Bundle\ReleaseBundle\Entity\ReleaseInterface;
use Hal\Bundle\ReleaseBundle\Entity\RequirementInterface;

class ReleaseService implements ReleaseServiceInterface
{

    public function getStateOf(ReleaseInterface $releaseToTest, ReleaseInterface $releaseCurrent = null)
    {

        if (is_null($releaseCurrent)) {
            return RequirementInterface::STATUS_UNKNOWN;
        }

        $versionToTest = $releaseToTest->getVersion();
        $versionCurrent = $releaseCurrent->getVersion();


        if (\strlen($versionCurrent) == 0) {
            return RequirementInterface::STATUS_UNKNOWN;
        }

        if(preg_match('!-(dev|RC|beta|alpha)$!', $versionToTest) ){
            return RequirementInterface::STATUS_DEV;
        }


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
