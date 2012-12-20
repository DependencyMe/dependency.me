<?php

namespace Hal\ReleaseBundle\Repository;

use Hal\ReleaseBundle\Release\Package\PackageInterface;
use Composer\Repository\RepositoryInterface as ComposerRepositoryInterface;

use Hal\ReleaseBundle\Release\Version\Release;

class ReleaseRepositoryComposer implements ReleaseRepositoryInterface
{

    private static $cache = array();
    private $composerRepository;

    function __construct(ComposerRepositoryInterface $composerRepository)
    {
        $this->composerRepository = $composerRepository;
    }

    public function findReleases(PackageInterface $package)
    {
        if (!isset(self::$cache[$package->getName()])) {

            //
            // File cache
            $filename = sprintf('cache/%s.releases.cache', $package->getName());
            if (!file_exists($filename)) {
                $results = $this->composerRepository->findPackages($package->getName());
                $releases = array();
                foreach ($results as $result) {
                    array_push($releases, new Release($result->getVersion()));
                }
                // cache results
                file_put_contents($filename, serialize($releases));
            } else {
                $releases = unserialize($filename);
            }

            //
            // Memory cache
            self::$cache[$package->getName()] = $releases;
        }
        return self::$cache[$package->getName()];
    }

}
