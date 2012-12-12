<?php

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

        $version = new Hal\ReleaseBundle\Release\Version\Release($givenVersion);
        $constraint = new \Hal\ReleaseBundle\Release\Version\Constraint($expectedVersion, $operator);
        $result = $constraint->isSatisfiedBy($version);

        $this->assertEquals($expectedResult, $result, sprintf('We want version %1$s %2$s, we get "%3$s" with "%4$s" ', $operator, $expectedVersion, (string) $result ? 'true' : 'false', $givenVersion));
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
        );
    }

}
