<?php

namespace Hal\ReleaseWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\SecurityExtraBundle\Annotation\SecureParam;

/**
 * @Route("/package")
 */
class PackageController extends Controller
{
    /**
     * @Secure(roles="ROLE_OWNER")
     * @Template
     * @Route("/add", name="package.add")
     */
    public function addPackageAction()
    {

    }

    /**
     * @Secure(roles="ROLE_OWNER")
     * @SecureParam(name="package", permissions="OWNER")
     * @Template
     * @Route("/remove/{id}", name="package.remove")
     */
    public function removePackage(\Hal\ReleaseBundle\Entity\Package $package)
    {

    }

    /**
     * @Template(vars={$package})
     * @Route("/display/{id}", name="package.display")
     */
    public function displayPackageAction(\Hal\ReleaseBundle\Entity\Package $package)
    {
    }

    /**
     * @Template
     * @Route("/image/{id}", name="package.image")
     */
    public function displayImageStateAction(\Hal\ReleaseBundle\Entity\Package $package)
    {

    }
}
