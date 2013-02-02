<?php

namespace Hal\Bundle\ReleaseWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/package")
 */
class PackageController extends Controller
{

    /**
     * @Route("/popular", name="package.list.popular")
     * @Template
     */
    public function listPopularAction()
    {
        return array(
            'packages' => $this->get('hal.release.package.service')->getPopulars()
        );
    }
}
