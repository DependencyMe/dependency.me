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
     * @Route("/out", name="owner.logout")
     */
    public function logOutAction() {
        $this->get('session')->clear();
        return $this->redirect('/'); // @todo : use route name
    }

    /**
     * @Route("/my-repositories", name="owner.list.repositories")
     */
    public function listRepositoriesAction() {
        $service = $this->get('hal.github.user.service');
        $owner = $this->get('session')->get('owner.auth.user');



        $repositories = $service->getPublicRepositories($owner);

        $content =  '';
        foreach($repositories as $repository) {
            $content .= '<br>repo '.$repository->name.':';
            $branches = $service->getBranchesOfRepository($owner, $repository->name);
            foreach($branches as $branche) {
                $content .= '<br> - '.$branche->name;
            }
        }

        return new \Symfony\Component\HttpFoundation\Response("<html><body>$content</body></html>");
    }

}
