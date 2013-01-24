<?php
namespace Hal\Bundle\GithubBUndle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Hal\Bundle\ReleaseBundle\Entity\Requirement;
use Hal\Bundle\ReleaseBundle\Factory\ConstraintFactory;

class LoadRequirementData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $datas = array(
            array('branche' => 'master', 'repository' => 'Behat', 'package'=>'symfony/yaml', 'requiredVersion'=> '>2', 'status' => 'latest'),
            array('branche' => 'master', 'repository' => 'Behat', 'package'=>'symfony/console', 'requiredVersion'=> '> 3', 'status' => 'unknown'),
            array('branche' => 'master', 'repository' => 'Behat', 'package'=>'symfony/config', 'requiredVersion'=> '1.2', 'status' => 'recent'),
            array('branche' => 'master', 'repository' => 'Behat', 'package'=>'behat/gherkin', 'requiredVersion'=> '1.*', 'status' => 'latest'),

            array('branche' => 'develop', 'repository' => 'Behat', 'package'=>'symfony/yaml', 'requiredVersion'=> '>2', 'status' => 'latest'),
            array('branche' => 'develop', 'repository' => 'Behat', 'package'=>'symfony/console', 'requiredVersion'=> '> 3', 'status' => 'unknown'),
            array('branche' => 'develop', 'repository' => 'Behat', 'package'=>'symfony/config', 'requiredVersion'=> '1.5', 'status' => 'latest'),
            array('branche' => 'develop', 'repository' => 'Behat', 'package'=>'behat/gherkin', 'requiredVersion'=> 'dev-master', 'status' => 'latest'),

            array('branche' => 'master', 'repository' => 'afup-book', 'package'=>'symfony/config', 'requiredVersion'=> '<1', 'status' => 'outofdate'),

            array('branche' => 'master', 'repository' => 'zf2', 'package'=>'symfony/config', 'requiredVersion'=> '<1', 'status' => 'outofdate'),
            array('branche' => 'master', 'repository' => 'zf2', 'package'=>'symfony/yaml', 'requiredVersion'=> '2.0', 'status' => 'recent'),

            array('branche' => 'release', 'repository' => 'zf2', 'package'=>'symfony/config', 'requiredVersion'=> '*', 'status' => 'latest'),
            array('branche' => 'release', 'repository' => 'zf2', 'package'=>'symfony/yaml', 'requiredVersion'=> '*', 'status' => 'latest'),


        );

        foreach ($datas as $data) {

            $constraintFactory = new ConstraintFactory();

            $object = new Requirement();
            $object
                ->setDeclaration($this->getReference(sprintf('declaration-%s-%s', $data['repository'], $data['branche'])))
                ->setPackage($this->getReference(sprintf('package-%s', $data['package'])))
                ->setRequiredVersion($constraintFactory->factory($data['requiredVersion']))
                ->setStatus($data['status'])
            ;
            $manager->persist($object);
            $manager->flush();
            $this->addReference(sprintf('requirement-%s-%s-%s', $data['repository'], $data['branche'], $data['package']), $object);
        }

    }

    public function getOrder()
    {
        return 13;
    }
}