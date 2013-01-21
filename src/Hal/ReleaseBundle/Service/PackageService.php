<?php

namespace Hal\ReleaseBundle\Service;

use Hal\ReleaseBundle\Repository\PackageRepositoryInterface;
use Hal\ReleaseBundle\Entity\Package;
use Hal\ReleaseBundle\Repository\Package\NotFoundException;
use Hal\ReleaseBundle\Repository\Package\InfoMissingException;

class PackageService implements PackageServiceInterface
{

    private $repository;

    function __construct(PackageRepositoryInterface $repository)
    {
        $this->repository = $repository;
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

    public function savePackage(Package $package)
    {
        return $this->repository->savePackage($package);
    }
}
