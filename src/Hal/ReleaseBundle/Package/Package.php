<?php

namespace Hal\ReleaseBundle\Package;
use Hal\ReleaseBundle\Version\SpecificationInterface;
class Package implements PackageInterface
{

    private $name;
    private $requires;
    private $devRequires;
    private $suggests;
    private $releaseDate;
    private $version;
    private $distUrl;
    private $distType;
    private $distSha1Checksum;
    private $stability;
    private $constraint;

    function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getConstraint()
    {
        return $this->constraint;
    }

    public function setConstraint(SpecificationInterface $constraint)
    {
        $this->constraint = $constraint;
    }

    public function getRequires()
    {
        return $this->requires;
    }

    public function setRequires(array $requires)
    {
        $this->requires = $requires;
        return $this;
    }

    public function getDevRequires()
    {
        return $this->devRequires;
    }

    public function setDevRequires(array $devRequires)
    {
        $this->devRequires = $devRequires;
        return $this;
    }

    public function getSuggests()
    {
        return $this->suggests;
    }

    public function setSuggests(array $suggest)
    {
        $this->suggests = $suggest;
        return $this;
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\Datetime $releaseDate)
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    public function getDistUrl()
    {
        return $this->distUrl;
    }

    public function setDistUrl($distUrl)
    {
        $this->distUrl = $distUrl;
        return $this;
    }

    public function getDistType()
    {
        return $this->distType;
    }

    public function setDistType($distType)
    {
        $this->distType = $distType;
        return $this;
    }

    public function getDistSha1Checksum()
    {
        return $this->distSha1Checksum;
    }

    public function setDistSha1Checksum($distSha1Checksum)
    {
        $this->distSha1Checksum = $distSha1Checksum;
        return $this;
    }

    public function getStability()
    {
        return $this->stability;
    }

    public function setStability($stability)
    {
        $this->stability = $stability;
        return $this;
    }

}
