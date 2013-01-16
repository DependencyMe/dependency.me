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
     * @Route("/synchronize", name="owner.synchronize")
     */
    public function synchronizeAction()
    {

        // $user = $this->get('security.context')->getToken()->getUser();
        $service = $this->get('hal.github.user.service');
        $owner = $this->get('session')->get('owner.auth.user');
        $repository = $this->get('hal.github.owner.repository');

        $service->synchronize($owner);

        $repository->saveOwner($owner);

        return $this->redirect('owner.list.repositories');
    }

    /**
     * @Template
     * @Route("/my-repositories", name="owner.list.repositories")
     * @Secure(roles="ROLE_USER")
     */
    public function listRepositoriesAction()
    {
        $owner = $this->get('session')->get('owner.auth.user');
        return array(
            'repositories' => $owner->getRepositories(),
            'owner' => $owner
        );
    }

}
