<?php

namespace Hal\Bundle\ReleaseBundle\Repository\Package;

use Hal\Bundle\ReleaseBundle\Entity\Package;
use Hal\Bundle\ReleaseBundle\Repository\Package\NotFoundException;
use Hal\Bundle\ReleaseBundle\Repository\Package\InfoMissingException;
use \Hal\Bundle\ReleaseBundle\Entity\Release;

abstract class ParserAbstract
{

    protected $package;
    protected $url;
    protected $lastVersion;
    protected $author;
    protected $releaseDate;
    protected $contentUrl;

    public function __construct(Package $package, $contentUrl)
    {
        $this->package = $package;
        $this->contentUrl = sprintf($contentUrl, $package->getName());
    }

    public function parse()
    {
        $this->loadContent();
    }

    public function loadContent()
    {
        $this->content = @file_get_contents($this->contentUrl);
        if (false === $this->content) {
            throw new NotFoundException(sprintf('Nothing found for "%s" at "%s"', $this->package->getName(), $this->contentUrl));
        }
    }

    protected function cleanVersion($version)
    {
        $version = trim($version);
        $version = preg_replace('!(dev-master)!', '', $version); // dev-master / 1.1
        $version = preg_replace('!^(\s*/\s*)!', '', $version); // dev-master / 1.1
        $version = trim($version);
        $version = preg_replace('!(@.*)$!', '', $version);
        $version = preg_replace('!(\\-.*)$!', '', $version);
        $version = preg_replace('!\\.\\*$!', '', $version);
        $version = preg_replace('!\\.x$!', '', $version);
        return $version;
    }

    protected function isValidVersion($version)
    {
        return 
        !in_array($version, array('dev', 'dev-master', ''))
        && preg_match('![0-9\.]{1,3}!', $version)

        ;
    }

    public function getPackage()
    {
        return $this->package;
    }

    public function getUrl()
    {
        return $this->url;
    }

    /**
     *
     * @return \Hal\Bundle\ReleaseBundle\Entity\Release
     */
    public function getLastVersion()
    {
        return $this->lastVersion;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

}
