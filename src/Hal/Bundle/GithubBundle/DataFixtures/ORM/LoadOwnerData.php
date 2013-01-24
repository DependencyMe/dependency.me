<?php
namespace Hal\Bundle\GithubBUndle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hal\Bundle\GithubBundle\Entity\Owner;

class LoadOwnerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $owner = new Owner;
        $owner
            ->setName('Jean-François Lépine')
            ->setLogin('Halleck45')
            ->setPermanentAccessToken('cf5d0821d6ddea76b364138024e7ee7dee89fcbf')
            ->setUrl('http://github.com/Halleck45')
            ->setEmail('jeanfrancois@lepine.pro')
            ->setGravatarUrl('http://www.gravatar.com/avatar/9848efe4596436395e8d0721faa24e00.png');

        $manager->persist($owner);
        $manager->flush();

        $this->addReference('owner-Halleck45', $owner);
    }

    public function getOrder()
    {
        return 1;
    }
}