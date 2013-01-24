<?php
namespace Hal\Bundle\GithubBUndle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Hal\Bundle\ReleaseBundle\Entity\Declaration;

class LoadDeclarationData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $datas = array(
            array('branche' => 'master', 'repository' => 'Behat'),
            array('branche' => 'develop', 'repository' => 'Behat'),
            array('branche' => 'master', 'repository' => 'afup-book'),
            array('branche' => 'release', 'repository' => 'zf2'),
            array('branche' => 'master', 'repository' => 'zf2'),
        );

        foreach ($datas as $data) {

            $object = new Declaration();
            $object
                ->setBranche($this->getReference(sprintf('branche-%s-%s', $data['repository'], $data['branche'])))
            ;
            $manager->persist($object);
            $this->addReference(sprintf('declaration-%s-%s', $data['repository'], $data['branche']), $object);

            $branche = $this->getReference(sprintf('branche-%s-%s', $data['repository'], $data['branche']));
            $branche->setDeclaration($object);
            $manager->persist($branche);
            $manager->flush();
        }

    }

    public function getOrder()
    {
        return 12;
    }
}