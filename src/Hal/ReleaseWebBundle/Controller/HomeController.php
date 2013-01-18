<?php

namespace Hal\ReleaseWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;


class HomeController extends Controller
{


    /**
     * @Route("", name="home")
     * @Template
     */
    public function homeAction()
    {
        return array();
    }

    /**
     * @Route("/save-session", name="save.session")
     */
    public function saveSessionAction()
    {
        $content = serialize($_SESSION);
        if(!file_exists('../tmp')) {
            mkdir('../tmp');
        }
        file_put_contents('../tmp/session.dump', $content);
        die('ok');
    }

    /**
     * @Route("/restore-session", name="restore.session")
     */
    public function restoreSessionAction()
    {

        $content = serialize($_SESSION);
        if(!file_exists('../tmp/session.dump')) {
            throw new Exception('Dump file not found');
        }
        $_SESSION = unserialize(file_get_contents('../tmp/session.dump'));
        return $this->redirect($this->generateUrl('home'));
        //die('ok, restauré');
    }

    /**
     * @Route("test1", name="test1")
     */
    public function test1Action()
    {


        $serviceRepo = $this->get('hal.github.repository.repository');
        $repository = $serviceRepo->getByName('Halleck45/Behat');
        foreach ($repository->getBranches() as $branche) {

            //
            // Get the declaration (infos about requirements)
            $service = $this->get('hal.release.declaration.service');
            $service->refreshDeclarationFromBranche($branche);
        }


        return new \Symfony\Component\HttpFoundation\Response('<html><body>essai</body>');

    }


    /**
     * @Route("test2", name="test2")
     */
    public function test2Action()
    {


        $serviceRepo = $this->get('hal.github.repository.repository');
        $repository = $serviceRepo->getByName('Halleck45/Behat');
        foreach ($repository->getBranches() as $branche) {

            $serviceDecl = $this->get('hal.release.declaration.service');
            $declaration = $serviceDecl->getByBranche($branche);

            foreach($declaration->getRequirements() as $requirement) {
                var_dump($requirement->getPackage()->getName());
                var_dump($requirement->getRequiredVersion()->getPrettyString());
            }
        }


        return new \Symfony\Component\HttpFoundation\Response('<html><body>essai</body>');

    }


}
