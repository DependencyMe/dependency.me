<?php

namespace Hal\ReleaseWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Hal\GithubBundle\Entity\Repository;
use \Hal\GithubBundle\Entity\Owner;

/**
 * @Route("/repository")
 */
class RepositoryController extends Controller
{


    /**
     * @Template
     * @Route("/owner/{login}", name="repository.list.by.owner")
     * @ParamConverter("owner", options={"mapping": {"login": "login"}})
     */
    public function repositoryListAction(Owner $owner)
    {
        return array(
            'repositories' => $owner->getRepositories(),
            'owner' => $owner,
            'requirementStatus' => $this->get('hal.release.requirement.service')
        );
    }

}
