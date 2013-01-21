<?php
use \Hal\ReleaseBundle\Entity\Release;
use Hal\ReleaseBundle\Entity\ReleaseInterface;
use Hal\ReleaseBundle\Service\ReleaseService;
use Hal\ReleaseBundle\Entity\RequirementInterface as R;

class ReleaseServiceTest extends PHPUnit_Framework_TestCase
{

    private $object;

    public function setUp()
    {
        $this->object = new ReleaseService;
    }

    /**
     * @dataProvider provideVersionsAndState
     */
    public function testICanGetTheStateOfVersionAccordingToAnother($versionToTest, $versionCurrent, $expectedState)
    {

        $releaseCurrent = new Release($versionCurrent);
        $releaseToTest = new Release($versionToTest);


        $state = $this->object->getStateOf($releaseToTest, $releaseCurrent);
        $this->assertEquals($expectedState, $state);
    }

    public function provideVersionsAndState()
    {
        return array(
            array('1', '3.5', R::STATUS_OUT_OF_DATE),
            array('1.5', '1.7', R::STATUS_RECENT),
            array('1.9', '1.9', R::STATUS_LATEST),
            array('2', '1.9', R::STATUS_LATEST),
            array('2', '1.9', R::STATUS_LATEST),
            array('2.4.3.2', '2.4.3.5', R::STATUS_RECENT),


        );
    }

}
