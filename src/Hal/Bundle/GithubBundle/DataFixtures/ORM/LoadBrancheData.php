<?php
namespace Hal\Bundle\GithubBUndle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hal\Bundle\GithubBundle\Entity\Branche;

class LoadBrancheData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $datas = array(
            array('name' => 'master', 'repository' => 'Behat'),
            array('name' => 'develop', 'repository' => 'Behat'),
            array('name' => 'master', 'repository' => 'afup-book'),
            array('name' => 'master', 'repository' => 'zf2'),
            array('name' => 'release', 'repository' => 'zf2'),
        );

        foreach ($datas as $data) {

            $branche = new Branche();
            $branche
                ->setName($data['name'])
                ->setRepository($this->getReference('repo-' . $data['repository']));

            $manager->persist($branche);
            $manager->flush();
            $this->addReference(sprintf('branche-%s-%s', $data['repository'], $data['name']), $branche);
        }

    }

    public function getOrder()
    {
        return 3;
    }
}