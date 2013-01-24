<?php
namespace Hal\Bundle\GithubBUndle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Hal\Bundle\ReleaseBundle\Entity\Package;
use Hal\Bundle\ReleaseBundle\Entity\Release;

class LoadPackageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $datas = array(
            array('name' => 'symfony/yaml', 'currentVersion' => '2.1', 'releaseDate' => '2012-12-23', 'url' => '', 'author' => 'Fabien Potencier', 'lastUpdate' => '2012-12-23'),
            array('name' => 'symfony/console', 'currentVersion' => '', 'releaseDate' => null, 'url' => '', 'author' => '', 'lastUpdate' => null),
            array('name' => 'symfony/config', 'currentVersion' => '1.5', 'releaseDate' => '2013-01-01', 'url' => '', 'author' => 'Fabien Potencier', 'lastUpdate' => '2013-01-24'),
            array('name' => 'behat/gherkin', 'currentVersion' => '1.1', 'releaseDate' => '2012-11-05', 'url' => '', 'author' => '@everzet', 'lastUpdate' => '2012-11-05'),
        );

        foreach ($datas as $data) {

            $object = new Package();
            $object
                ->setName($data['name'])
                ->setUrl($data['url'])
                ->setAuthor($data['url'])
                ->setCurrentVersion(new Release($data['currentVersion']))
                ->setReleaseDate(new \DateTime($data['releaseDate']))
                ->setLastUpdate(is_null($data['lastUpdate']) ? null : new \DateTime($data['lastUpdate']));

            $manager->persist($object);
            $manager->flush();
            $this->addReference(sprintf('package-%s', $data['name']), $object);
        }

    }

    public function getOrder()
    {
        return 11;
    }
}