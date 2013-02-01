<?php

namespace Hal\Bundle\ReleaseBundle\Repository\Package\Parser;

use \Hal\Bundle\ReleaseBundle\Repository\Package\ParserAbstract;
use Hal\Bundle\ReleaseBundle\Entity\Package;
use Hal\Bundle\ReleaseBundle\Repository\Package\NotFoundException;
use Hal\Bundle\ReleaseBundle\Repository\Package\InfoMissingException;
use \Hal\Bundle\ReleaseBundle\Entity\Release;

class ParserPackagistRss extends ParserAbstract
{

    public function parse()
    {
        parent::parse();
       
        $xml = new \SimpleXMLElement($this->content);
        $info = $xml->channel->item[0];

        if(!isset($info, $info->title)) {
            throw new NotFoundException;
        }

        // found in the rss
        if (!preg_match('!\\((.*)\\)!', $info->title, $matches)) {
            throw new InfoMissingException("Package {$package->getName()} : cannot parse the given version ($info->title)");
        }
        $v = preg_replace('!^v!', '', $matches[1]);

        $this->url = $info->link;
        $this->releaseDate = new \DateTime($info->pubDate);
        $this->author = $info->author;
        $this->version = new Release($v);
    }

}
