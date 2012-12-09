<?php

namespace Hal\ReleaseBundle\Release\Package;

interface PackageInterface
{

    public function getConstraint();

    public function setConstraint(\Hal\ReleaseBundle\Release\Version\SpecificationInterface $constraint);

    public function setRequires(array $packages);

    public function getRequires();

    public function setDevRequires(array $packages);

    public function getDevRequires();

    public function setSuggests(array $packages);

    public function getSuggests();

    public function setReleaseDate(\Datetime $date);

    public function getReleaseDate();

    public function setVersion($version);

    public function getVersion();

    public function setDistUrl($url);

    public function getDistUrl();

    public function setDistType($type);

    public function getDistType();

    public function setDistSha1Checksum($sha1);

    public function getDistSha1Checksum();

    public function setStability($stability);

    public function getStability();
}
