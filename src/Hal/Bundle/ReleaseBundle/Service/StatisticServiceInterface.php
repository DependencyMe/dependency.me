<?php
namespace Hal\Bundle\ReleaseBundle\Service;
/**
 * Allows to manipulate the Statistic's domain
 *
 * @author Jean-François Lépine
 */
interface StatisticServiceInterface
{
    public function getRegisteredSum();
    public function getResultAvg();
    public function getResultSum();
}