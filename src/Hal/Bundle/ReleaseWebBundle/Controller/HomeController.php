<?php

namespace Hal\Bundle\ReleaseWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class HomeController extends Controller
{

    /**
     * @Route("", name="home")
     * @Template
     */
    public function homeAction()
    {
        return array(
            'statistic' => array(
                'sum' => $this->get('hal.release.statistic.service')->getRegisteredSum()
            ),
            'repositories' => $this->get('hal.github.repository.service')->listRecentlyUpdated()
        );
    }
}
