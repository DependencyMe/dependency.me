<?php

namespace Hal\ReleaseBundle\Release\Package;

use Composer\Package\PackageInterface as ComposerPackageInterface;
use Composer\Package\Link as ComposerPackageLinkInterface;
use Hal\ReleaseBundle\Release\Package\Package;

class PackageFactory
{

    public function factory($package)
    {
        switch (true) {
            case ($package instanceof ComposerPackageInterface):
                return $this->factoryFromComposerPackage($package);
                break;
            case ($package instanceof ComposerPackageLinkInterface):
                return $this->factoryFromComposerPackageLink($package);
                break;
            default:
                throw new \Exception('Package type is not supported');
                break;
        }
    }

    public

    function factoryFromComposerPackage(ComposerPackageInterface $compoPackage)
    {
        $package = new Package($compoPackage->getName());

        $package
            ->setVersion($compoPackage->getVersion())
            ->setDistUrl($compoPackage->getDistUrl())
            ->setDistType($compoPackage->getDistType())
            ->setDistSha1Checksum($compoPackage->getDistSha1Checksum())
            ->setStability($compoPackage->getStability())
        ;
        if ($compoPackage->getReleaseDate() != null) {
            $package->setReleaseDate($compoPackage->getReleaseDate());
        }


        //
        // proxies
        $requires = $compoPackage->getRequires();
        $proxies = array();
        foreach ($requires as $require) {
            array_push($proxies, $this->factoryFromComposerPackageLink($require));
        }
        $package->setRequires($proxies);


        $devRequires = $compoPackage->getDevRequires();
        $proxies = array();
        foreach ($devRequires as $require) {
            array_push($proxies, $this->factoryFromComposerPackageLink($require));
        }
        $package->setDevRequires($proxies);


        $package->setSuggests($compoPackage->getSuggests());

        return $package;
    }

    public function factoryFromComposerPackageLink(ComposerPackageLinkInterface $link)
    {
        $package = new Package($link->getTarget());

        $factory = new \Hal\ReleaseBundle\Release\Version\ConstraintFactory;
        $constraint = $factory->factory($link->getConstraint());
        $package->setConstraint($constraint);
        return $package;
    }

}
