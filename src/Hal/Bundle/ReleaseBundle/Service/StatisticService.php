<?php
namespace Hal\Bundle\ReleaseBundle\Service;
use Hal\Bundle\ReleaseBundle\Repository\StatisticRepositoryInterface;

/**
 * Allows to manipulate the Statistic's domain
 *
 * @author Jean-François Lépine
 * @implements ServiceStatisticInterface
 */
class StatisticService implements StatisticServiceInterface
{

    /**
     * @var StatisticRepositoryInterface
     */
    private $repository;

    public function __construct(StatisticRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getRegisteredSum()
    {
        return $this->repository->getRegisteredSum();
    }

    public function getResultAvg()
    {
        //return $this->repository->getResultAvg();
    }

    public function getResultSum()
    {
        //return $this->repository->getResultSum();
    }

}