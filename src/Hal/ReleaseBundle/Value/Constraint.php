<?php

namespace Hal\ReleaseBundle\Value;

use Hal\ReleaseBundle\Entity\ReleaseInterface;
use Hal\ReleaseBundle\Specification\ConstraintSpecificationInterface;
class Constraint implements ConstraintInterface, ConstraintSpecificationInterface
{

    private $version;
    private $operator;

    function __construct($version, $operator)
    {
        $this->version = $version;
        $this->operator = $operator;
    }

    public function isSatisfiedBy(ReleaseInterface $versionGiven)
    {
        $versionGiven = $versionGiven->getVersion();
        $versionRequired = $this->getVersion();
        $v1Parts = explode('.', $versionRequired);
        $versionRequired.=str_repeat('.0', 4 - count($v1Parts));
        $v2Parts = explode('.', $versionGiven);
        $versionGiven.=str_repeat('.0', 4 - count($v2Parts));
        $operator = $this->getOperator();
        if (preg_match('!\*!', $versionRequired)) {
            // specific rule.
            switch ($operator) {
                case '=':
                    // expected : 2.3.*
                    //    min : >= 2.3.0
                    //    max : <= 2.4
                    $versionRequiredMin = preg_replace('!(.\\*)!', '.0', $versionRequired);
                    $bool1 = version_compare($versionGiven, $versionRequiredMin, '>=');
                    $versionRequiredMax = preg_replace_callback('!(\d*)(\.\*)!', function($matches) {
                            return
                                ((int) $matches[1] + 1)
                                . '.0'; // $matches[2];
                        }
                        , $versionRequired);
                    $bool2 = version_compare($versionGiven, $versionRequiredMax, '<');
                    return $bool1 && $bool2;
                    break;
            }
        }
        if (!version_compare($versionGiven, $versionRequired, $operator)) {
            return false;
        }
        return true;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function getPrettyString()
    {
        return $this->operator . $this->version;
    }

}
