<?php

namespace Hal\ReleaseWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Hal\GithubBundle\Entity\Repository;

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
     *
     */
    public function repositoryListAction()
    {
        // @todo : use @Secure(roles="ROLE_USER")
        $owner = $this->expectingAnnotationCheckAuth();

        return array(
            'repositories' => $owner->getRepositories(),
            'owner' => $owner
        );
    }

    /**
     * @Route("/enable/{name}", defaults={"enable": "1"}, name="owner.repository.enable" )
     * @Route("/disable/{name}", defaults={"enable": "0"}, name="owner.repository.disable" )
     * @ParamConverter("repository", options={"mapping": {"name": "name"}})
     */
    public function repositoryEnableAction(Repository $repository)
    {
        // @todo : use @Secure(roles="ROLE_USER")
        // @todo : use @SecureParam(name="repository", permissions="OWNER")
        $owner = $this->expectingAnnotationCheckAuth();

        $service = $this->get('hal.github.repository.service');
        $repository->setEnabled((boolean)$this->get('request')->get('enable'));
        $service->saveRepository($repository);

        return new RedirectResponse($this->generateUrl('owner.list.repositories'));
    }


    private function expectingAnnotationCheckAuth()
    {
        $service = $this->get('hal.github.user.service');
        $owner = $service->getOwnerByLogin('Jeff');

        if (is_null($owner) || !$owner instanceof \Hal\GithubBundle\Entity\Owner) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Owner Jeff not found');
        }

        return $owner;
    }
}
