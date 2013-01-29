<?php

namespace Hal\Bundle\ReleaseWebBundle\Controller;

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


        return array(
            'statistic' => array(
                'sum' => $this->get('hal.release.statistic.service')->getRegisteredSum()
            ),
            'repositories' => $this->get('hal.github.repository.service')->listRecentlyUpdated()
        );
    }

    /**
     * @Route("/save-session", name="save.session")
     */
    public function saveSessionAction()
    {
        $content = serialize($_SESSION);
        if (!file_exists('../tmp')) {
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
        if (!file_exists('../tmp/session.dump')) {
            throw new Exception('Dump file not found');
        }
        $_SESSION = unserialize(file_get_contents('../tmp/session.dump'));
        return $this->redirect($this->generateUrl('home'));
        //die('ok, restauré');
    }


    /**
     * @Route("/test1", name="test1")
     */
    public function test1Action() {
        $limit = 2;
        $maxDay = new \DateTime('yesterday');
        $service = $this->get('hal.release.declaration.service');
        $branches = $service->getOldestDeclarations($limit, $maxDay);

        foreach ($branches as $branche) {


            //
            // Get the declaration (infos about requirements)
            $service->refreshDeclarationFromBranche($branche);
            $service->saveDeclaration($branche->getDeclaration());

        }

        return new \Symfony\Component\HttpFoundation\Response('<html><body></body>');

    }
}

/*
SELECT
    b0_.id AS id0,
    b0_.name AS name1,
    b0_.lastUpdate AS lastUpdate2,
    d1_.id AS id3,
    d1_.lastUpdate AS lastUpdate4,
    b0_.declaration_id AS declaration_id5,
    b0_.repository_id AS repository_id6
FROM
    Branche b0_
LEFT JOIN
    Declaration d1_
    ON (d1_.lastUpdate < NOW() OR d1_.id IS NULL)
ORDER BY
    d1_.lastUpdate ASC
    LIMIT 2;
*/