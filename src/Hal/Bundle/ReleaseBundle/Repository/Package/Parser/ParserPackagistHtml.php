<?php

namespace Hal\Bundle\ReleaseBundle\Repository\Package\Parser;

use Hal\Bundle\ReleaseBundle\Repository\Package\ParserAbstract;
use Hal\Bundle\ReleaseBundle\Entity\Package;
use Hal\Bundle\ReleaseBundle\Repository\Package\NotFoundException;
use Hal\Bundle\ReleaseBundle\Repository\Package\InfoMissingException;
use \Hal\Bundle\ReleaseBundle\Entity\Release;

class ParserPackagistHtml extends ParserAbstract
{

    public function parse()
    {
        parent::parse();


        $regexes = array(
            sprintf('!https://github.com/%s/tree/([\\w\\d\\.\\-]*)"!i', $this->package->getName()) // URL of github repository
            , sprintf('!value="&quot;%s&quot;: &quot;(.*)&quot;"!i', $this->package->getName())// given code
            , '!(?:version|version last)">\s*<section>\s*<h1>\s*v?([0-9\.\w\-/\s]*)\s*([0-9\.]*)\s*<span!i' // list of version
        );

        //
        // Fixes anomalies with <version><section><1>master</h1>
        $content = preg_replace('!(version">\s*<section>\s*<h1>\s*(dev-master|dev|master|master-dev)\s*<span)!i', '', $this->content);
        foreach ($regexes as $regex) {
            if (preg_match($regex, $content, $matches)) {

                $version = $this->cleanVersion($matches[1]);
                if ($this->isValidVersion($version)) {
                    $this->lastVersion = new Release($version);
                    return;
                }
            }
        }
        throw new InfoMissingException("No information found for '{$this->package->getName()}' ");
    }

}
