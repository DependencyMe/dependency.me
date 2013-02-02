<?php

namespace Hal\Bundle\ReleaseWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Hal\Bundle\GithubBundle\Entity\Repository;
use Hal\Bundle\GithubBundle\Request\ParamConverter\RepositoryParamConverter;

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
        $service = $this->get('hal.github.owner.service');

        $owner = $this->getUser();
        $service->synchronize($owner);

        $service->saveOwner($owner);

        return $this->redirect($this->generateUrl('owner.repository.list'));
    }

    /**
     * @Template
     * @Route("/my-repositories", name="owner.repository.list")
     * @Secure(roles="ROLE_USER")
     */
    public function repositoryListAction()
    {
        return array(
            'repositories' => $this->get('hal.github.repository.service')->getByOwner($this->getUser()),
            'owner' => $this->getUser()
        );
    }

    /**
     * @Route("/enable/{owner}/{repository}", defaults={"enable": "1"}, name="owner.repository.enable" )
     * @Route("/disable/{owner}/{repository}", defaults={"enable": "0"}, name="owner.repository.disable" )
     * @RepositoryParamConverter("repository", class="HalGithubBundle:Repository")
     * @SecureParam(name="repository", permissions="OWNER")
     */
    public function repositoryEnableAction(Repository $repository)
    {
        $service = $this->get('hal.github.repository.service');
        $repository->setEnabled((boolean) $this->get('request')->get('enable'));
        $service->saveRepository($repository);
        return new RedirectResponse($this->generateUrl('owner.repository.list'));
    }

}