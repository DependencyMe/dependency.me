<?php

namespace Hal\GithubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Hal\GithubBundle\Auth\AuthServiceInterface;

/**
 * @Route("/github")
 */
class PackageController extends Controller
{
    /**
     * @Route("/auth", name="github.auth")
     */
    public function authentificateAction()
    {
        $serviceOwner = $this->get('hal.release.owner.service');
        $serviceAuth->authentificate();
        return new RedirectResponse('home');
    }
}
