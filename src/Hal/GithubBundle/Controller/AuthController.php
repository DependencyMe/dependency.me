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
        $service = $this->get('hal.github.auth.service');
        $user = $this->get('session')->get('github.auth.user');
        if (!$user) {
            $user = new \Hal\GithubBundle\Entity\Authentifiable();
        }
        $service->authentificate($user);
        return new RedirectResponse('home');
    }

}
