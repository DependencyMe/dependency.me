<?php
namespace Hal\Bundle\GithubBUndle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hal\Bundle\GithubBundle\Entity\Repository;

class LoadRepositoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $repos = array(
            array('name' => 'afup-book', 'owner' => 'Halleck45', 'enabled' => 1),
            array('name' => 'Behat', 'owner' => 'Halleck45', 'enabled' => 1),
            array('name' => 'zf2', 'owner' => 'Halleck45', 'enabled' => 0)
        );

        foreach ($repos as $repoInfo) {

            $repo = new Repository();
            $repo->setName($repoInfo['name'])
                ->setGitUrl(sprintf('git://github.com/%s/%s.git', $repoInfo['owner'], $repoInfo['name']))
                ->setUrl(sprintf('git://github.com/%s/%s', $repoInfo['owner'], $repoInfo['name']))
                ->setPrivate('0')
                ->setEnabled($repoInfo['enabled'])
                ->setOwner($this->getReference('owner-' . $repoInfo['owner']));

            $manager->persist($repo);
            $manager->flush();
            $this->addReference('repo-' . $repoInfo['name'], $repo);
        }

    }

    public function getOrder()
    {
        return 2;
    }
}