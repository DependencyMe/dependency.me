<?php

namespace Hal\GithubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Hal\GithubBundle\Service\AuthServiceInterface;

/**
 * @Route("/github")
 */
class AuthController extends Controller
{

}
