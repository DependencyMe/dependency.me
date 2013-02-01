<?php

use Hal\Bundle\ReleaseBundle\Entity\Package;
use Hal\Bundle\ReleaseBundle\Repository\Package\Parser\ParserPackagistHtml;

/**
 * @group package
 */
class PackageParserTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->fixtureUrl = __DIR__ . '/fixtures/%s.html';
    }

    /**
     * @dataProvider provideValidPackages
     */
    public function testICanObtainTheVersionOfAPakageRegisteredOnPackagagist($name, $expectedVersion)
    {

        $package = new Package;
        $package->setName(str_replace('/', '-', $name)); // replace "/" by "-"
        $parser = new ParserPackagistHtml($package, $this->fixtureUrl);
        $parser->parse();


        $this->assertEquals(
            $expectedVersion
            , $parser->getLastVersion($package)->getPrettyString()
        );
    }

    public function provideValidPackages()
    {
        return array(
            array('symfony/symfony', '2.2') // dev-master / x.x
            , array('fusepump/cli', '0.2.0') // 0.2
            , array('symfony/css-selector', '2.3')
            , array('doctrine/annotations', '1.0') // v1.0
            , array('pond/tunes', '0.3.2') // v0.3.2
        );
    }

}
