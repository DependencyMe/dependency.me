<?php

namespace Hal\ReleaseWebBundle\Controller;

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
        return array();
    }


}
