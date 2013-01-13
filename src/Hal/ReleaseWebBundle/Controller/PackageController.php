<?php

namespace Hal\ReleaseWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
     * @Route("/search/{searchedTerm}", name="package.search")
     * @Template
     */
    public function searchAction($searchedTerm) {
        $service = $this->get('hr.package.service');
        return array(
            'packages' => $service->getMatchingPackages($searchedTerm)
            ,'searchedTerm' => $searchedTerm
        );
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
     * @Template(vars={"package"})
     * @Route("/display/{name}", name="package.display")
     * @ParamConverter ("package", options={"mapping": {"name": "name"}})
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
