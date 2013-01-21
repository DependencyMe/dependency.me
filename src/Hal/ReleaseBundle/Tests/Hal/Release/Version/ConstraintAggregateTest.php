<?php
use \Hal\ReleaseBundle\Value\Constraint;
use \Hal\ReleaseBundle\Value\ConstraintAggregate;
use \Hal\ReleaseBundle\Entity\Release;

class ConstraintAggregateTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {

    }


    /**
     * @dataProvider provideLimitsAccordingConstraint
     */
    public function testICanGetTheMinimalAndMaximalVersionAvailable($required, $min, $max)
    {

        $factory = new \Hal\ReleaseBundle\Factory\ConstraintFactory();
        $constraintAggregate = $factory->factory($required);

        $limit = $constraintAggregate->getMinAndMax();
        $this->assertEquals($min, $limit->min);
        $this->assertGreaterThanOrEqual($max, $limit->max);
    }

    public function provideLimitsAccordingConstraint()
    {
        return array(
            array('=1.1', '1.1.0.0', '1.1.0.0')
        , array('>1.1', '1.2.0.0', '99999')
        , array('>=1.1', '1.1.0.0', '99999')
        , array('>=1.*', '1.0.0.0', '1.9.9.9')
        , array('<1.1', '1.0.0.0', '1.0.9.9')
        , array('<=1.1', '1.0.0.0', '1.1.0.0')
        , array('<=1.*', '0.0.0.1', '1.9.9.9')
        , array('<3,>1', '2.0.0.0', '2.9.9.9')
        , array('<3,>=2', '2.0.0.0', '2.9.9.9')
        , array('<=3,>2', '2.0.0.0', '3.0.0.0')
        );

    }


}
