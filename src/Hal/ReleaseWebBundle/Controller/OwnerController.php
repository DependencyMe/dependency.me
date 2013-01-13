<?php

namespace Hal\ReleaseWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * @Route("/owner")
 */
class OwnerController extends Controller
{
    /**
     * @Route("/auth", name="owner.register")
     */
    public function registerAction()
    {

        $service = $this->get('hr.owner.service');
        $service->authentificate();

        return $this->redirect($this->generateUrl('owner.list.repositories'));
    }

    /**
     * @Route("/my-repositories", name="owner.list.repositories")
     */
    public function listRepositoriesAction() {
        var_dump($this->get('session')->get('owner.auth.user'));

        exit;
        $tk = $this->get('session')->get('owner.auth.user')->getPermanentAccessToken();

        $url = 'https://api.github.com/users/repos?access_token='.$tk;
        die(file_get_contents($url));
        die('ok');
    }

}
