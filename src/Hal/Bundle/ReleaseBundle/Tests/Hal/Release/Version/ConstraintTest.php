<?php
use \Hal\Bundle\ReleaseBundle\Value\Constraint;
use \Hal\Bundle\ReleaseBundle\Entity\Release;

class ConstraintTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {

    }

    /**
     * @dataProvider provideVersionAccordingConstraint
     */
    public function testCheckIfConstraintIsSatisfiedByVersion($operator, $expectedVersion, $givenVersion, $expectedResult)
    {

        $version = new Release($givenVersion);
        $constraint = new Constraint($expectedVersion, $operator);
        $result = $constraint->isSatisfiedBy($version);

        $this->assertEquals($expectedResult, $result, sprintf('We want version %1$s %2$s, we get "%3$s" with "%4$s" ', $operator, $expectedVersion, (string)$result ? 'true' : 'false', $givenVersion));
    }


    /**
     * @dataProvider provideLimitsAccordingConstraint
     * @group tmp
     */
    public function testICanGetTheMinimalAndMaximalVersionAvailable($operator, $expectedVersion, $min, $max)
    {
        $constraint = new Constraint($expectedVersion, $operator);
        $limit = $constraint->getMinAndMax();
        $this->assertEquals($min, $limit->min);
        $this->assertEquals($max, $limit->max);
    }

    public function provideLimitsAccordingConstraint()
    {
        return array(
            array('>', '1.1', '1.2.0.0', '99999')
        , array('>', '2', '3.0.0.0', '99999')
        , array('>', '2.*', '3.0.0.0', '99999')
        , array('>', '2.x', '3.0.0.0', '99999')
        , array('=', '2', '2.0.0.0', '2.9.9.9')
        , array('=', '2.5', '2.5.0.0', '2.5.9.9')
        , array('=', '2.*', '2.0.0.0', '2.9.9.9')
        , array('=', '2.0.*', '2.0.0.0', '2.0.9.9')
        , array('<', '2.3', '2.0.0.0', '2.2.9.9')
        , array('<', '2.*', '1.0.0.0', '1.9.9.9')
        , array('<', '2.5.*', '2.0.0.0', '2.4.9.9')
        , array('<', '2.2.0-dev', '2.0.0.0', '2.1.9.9')
        , array('<=', '2.5.*', '2.0.0.0', '2.5.9.9')
        , array('<=', '2.1.*', '2.0.0.0', '2.1.9.9')
        , array('<=', '1.*', '0.0.0.1', '1.9.9.9')
        , array('<=', '2.5', '2.0.0.0', '2.5.9.9')
        , array('>=', '2.5', '2.5.0.0', '99999')
        , array('>=', '2.*', '2.0.0.0', '99999')
        , array('=', 'dev-master', '0.0.0.1', '99999')
        , array('=', 'master', '0.0.0.1', '99999')
        , array('=', 'master-dev', '0.0.0.1', '99999')
        );

    }

    public function provideVersionAccordingConstraint()
    {
        return array(
            array('>', '1.1', '2.0', true)
        , array('>', '2.0.2', '2.0.3', true)
        , array('>', '2.0.0.2', '2.0.0.3', true)
        , array('>', '1.1', '1.0', false)
        , array('>', '2.0.2', '2.0.1', false)
        , array('>', '2.0.0.2', '2.0.0.1', false)
        , array('>', '2.*', '2.0.0.1', true)
        , array('>', '2.*', '3', true)
        , array('>', '2.x', '3', true)
            //
        , array('>=', '1.1', '2.0', true)
        , array('>=', '1.1', '1.1', true)
        , array('>=', '2.0.2', '2.0.3', true)
        , array('>=', '2.0.2', '2.0.2', true)
        , array('>=', '2.0.0.2', '2.0.0.3', true)
        , array('>=', '2.0.0.2', '2.0.0.2', true)
        , array('>=', '1.1', '1.0', false)
        , array('>=', '2.0.2', '2.0.1', false)
        , array('>=', '2.0.0.2', '2.0.0.1', false)
        , array('>=', '2.*', '2.0.0.1', true)
        , array('>=', '2.*', '3', true)
            //
        , array('<', '1.1', '1.0', true)
        , array('<', '2.0.2', '2.0.1', true)
        , array('<', '2.0.0.2', '2.0.0.1', true)
        , array('<', '1.1', '1.1', false)
        , array('<', '2.0.2', '2.0.3', false)
        , array('<', '2.0.0.2', '2.0.0.3', false)
        , array('<', '2.*', '2.0.0.1', false)
        , array('<', '2.*', '3', false)
            //
        , array('<=', '1.1', '1.0', true)
        , array('<=', '1.1', '1.1', true)
        , array('<=', '2.0.2', '2.0.1', true)
        , array('<=', '2.0.2', '2.0.2', true)
        , array('<=', '2.0.0.2', '2.0.0.1', true)
        , array('<=', '2.0.0.2', '2.0.0.2', true)
        , array('<=', '1.1', '1.1', true)
        , array('<=', '2.0.2', '2.0.3', false)
        , array('<=', '2.0.0.2', '2.0.0.3', false)
        , array('<=', '2.*', '2.0.0.1', false)
        , array('<=', '2.*', '3', false)
            //
        , array('=', '1.1', '1.1', true)
        , array('=', '1.*', '1.2', true)
        , array('=', '1.*', '2.2', false)
        , array('=', '1.2.*', '1.2.4', true)
        , array('=', '1.2.*', '1.3', false)
        , array('=', '1.2.x', '1.3', false)
        );
    }

}
