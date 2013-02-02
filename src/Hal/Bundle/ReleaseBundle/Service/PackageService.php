<?php

namespace Hal\Bundle\ReleaseBundle\Service;

use Hal\Bundle\ReleaseBundle\Repository\PackageRepositoryInterface;
use Hal\Bundle\ReleaseBundle\Entity\Package;
use Hal\Bundle\ReleaseBundle\Repository\Package\NotFoundException;
use Hal\Bundle\ReleaseBundle\Repository\Package\InfoMissingException;

class PackageService implements PackageServiceInterface
{

    private $repository;
    private $options;

    function __construct(PackageRepositoryInterface $repository, array $options = array())
    {
        $this->repository = $repository;
        $this->options = $options;
    }


    public function getOrCreateByName($name)
    {
        $package = $this->repository->getByName($name);
        if (!$package) {

            $package = new Package();
            $package->setName($name);

            try {
                $this->refreshPackage($package);
            } catch (NotFoundException $e) {
            } catch (InfoMissingException $e) {
            }

        }

        return $package;
    }


    public function refreshPackage(Package $package)
    {
        $infos = $this->repository->getInfosOfPackage($package);

        $package
            ->setCurrentVersion($infos->version)
            ->setReleaseDate($infos->releaseDate)
            ->setUrl($infos->url)
            ->setAuthor($infos->author);
    }

    public function getOldestPackages($limit, $maxDay){
        return $this->repository->getOldestPackages($limit, $maxDay);
    }

    public function savePackage(Package $package)
    {
        return $this->repository->savePackage($package);
    }

    public function getPopulars() {
        $limit = (int) $this->options['display']['packages']['popular'];
        return $this->repository->getPopulars($limit);
    }
}
