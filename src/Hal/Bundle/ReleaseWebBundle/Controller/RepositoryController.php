<?php

namespace Hal\Bundle\ReleaseWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Hal\Bundle\GithubBundle\Entity\Repository;
use Hal\Bundle\GithubBundle\Entity\Branche;
use \Hal\Bundle\GithubBundle\Entity\Owner;

use Hal\Bundle\GithubBundle\Request\ParamConverter\BrancheParamConverter;
use Hal\Bundle\GithubBundle\Request\ParamConverter\OwnerParamConverter;
use Symfony\Component\HttpFoundation\Request ;

/**
 * @Route("/repository")
 */
class RepositoryController extends Controller
{


    /**
     * @Template
     * @Route("/search/{expression}", name="repository.search"
     * , requirements={
     *        "expression" = "[\w\d\-\./]+"
     *      }
     *  ,defaults={"expression"=""}
     * )
     */
    public function repositorySearchAction(Request $request)
    {

        $service = $this->get('hal.github.repository.service');
        return array(
            'repositories' => $service->search($request->get('expression')),
        );
    }

    /**
     * @Template
     * @Route("/owner/{login}", name="repository.list.by.owner")
     * @OwnerParamConverter("owner", class="HalGithubBundle:Owner")
     */
    public function repositoryListAction(Owner $owner)
    {
        return array(
            'repositories' => $owner->getRepositories(),
            'owner' => $owner,
        );
    }


    /**
     * @Template
     * @Route("/branche/{owner}/{repository}/{branche}", name="branche.display"
     *       , requirements={
     *              "repository" = "[\w\d\-]+",
     *              "branche" = "[\w\d\-\./]+"
     *      }
     * )
     * @BrancheParamConverter("branche", class="HalGithubBundle:Branche")
     */
    public function brancheDisplayAction(Branche $branche)
    {

        return array(
            'branche' => $branche,
            'owner' => $branche->getRepository()->getOwner(),
        );
    }
}
