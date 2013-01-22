<?php

namespace Hal\Bundle\ReleaseBundle\Value;

use Hal\Bundle\ReleaseBundle\Entity\ReleaseInterface;
use Hal\Bundle\ReleaseBundle\Specification\ConstraintSpecificationInterface;
use Composer\Package\BasePackage as ComposerPackage;

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
        $versionRequired .= str_repeat('.0', 4 - count($v1Parts));
        $v2Parts = explode('.', $versionGiven);
        $versionGiven .= str_repeat('.0', 4 - count($v2Parts));
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
                    $versionRequiredMax = preg_replace_callback('!(\d*)(\.\*)!', function ($matches) {
                            return
                                ((int)$matches[1] + 1)
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


    public function getMinAndMax()
    {

        $version = $this->getVersion();
        $version = preg_replace('!(\\.0)$!', '', $version);
        $version = preg_replace('!(\\-dev)$!', '', $version);
        $operator = $this->getOperator();


        if (in_array($version, array_merge(ComposerPackage::$stabilities, array('master', 'dev-master')))) {
            $version = '*';
        }

        if (false !== strpos($version, '*')) {
            switch ($operator) {
                case '>':
                case '>=':
                case '=>':
                    $version = preg_replace('!\\.\\*!', '', $version);
                    break;
                case '=':
                    $version = preg_replace('!\\*!', '0', $version);
                    $operator = '=';
                    break;
                case '<':
                case '<=':
                case '=<':
                    $version = preg_replace('!\\*!', '0', $version);
                    break;
            }

        }

        $version = preg_replace('!(\\.0)$!', '', $version);

        if (!preg_match('!(\d)$!', $version, $matches)) {
            throw new \Exception(sprintf('unsupported value "%s"', $version));
        }

        $lastNumber = $matches[1];

        preg_match('!^(\d)!', $version, $matches);
        $firstNumber = $matches[1];


        switch ($operator) {
            case '=':
                $min = $max = $version;
                break;
            case '>':
                $min = preg_replace('!(\d)$!', $lastNumber + 1, $version);
                $max = 99999;
                break;
            case '>=':
            case '=>':
                $min = $version;
                $max = 99999;
                break;
            case '<':
                if (strlen($version) == 1) {
                    $min = preg_replace('!(\d)$!', $lastNumber - 1, $version);
                    ;
                } else {
                    $min = $firstNumber;
                }
                $max = preg_replace('!(\d)$!', $lastNumber - 1, $version);
                break;
            case '<=':
            case '=<':
                if (strlen($version) == 1) {
                    $min = preg_replace('!(\d)$!', $lastNumber - 1, $version);
                    ;
                } else {
                    $min = $firstNumber;
                }
                $max = $version;
                break;

        }


        // Padding
        while (substr_count($min, '.') < 3) {
            $min .= '.0';
        }
        if ($max != 99999) {
            while (substr_count($max, '.') < 3) {
                $max .= '.9';
            }
        }

        if ($min == '0.0.0.0') {
            $min = '0.0.0.1';
        }

        return (object)array('min' => $min, 'max' => $max);

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

    public function __toString()
    {
        return $this->getPrettyString();
    }

}
