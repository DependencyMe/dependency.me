<?php

namespace Hal\Bundle\GithubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Hal\Bundle\GithubBundle\Service\AuthServiceInterface;

class BadController extends Controller
{
    /**
     * @Route("/bad ", name="github.bad")
     */
    public function badAction()
    {
        $this->redirect($this->generateUrl('home'));
    }

}
