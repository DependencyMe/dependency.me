<?php

namespace Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\Release;

use Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\HalContext;
use Behat\Behat\Exception\PendingException;
use Hal\Bundle\GithubBundle\Entity\Owner;

class OwnerContext extends HalContext
{

    /**
     * @Given /^I\'m visitor$/
     */
    public function iMVisitor()
    {
        
    }

    /**
     * @Given /^the owner "([^"]*)" is registerd$/
     */
    public function theOwnerIsRegisterd($name)
    {
        $persister = $this->getPersister();
        $owner = $persister->createOwnerFromArray(array('login' => $name));
        $persister->save($owner);
    }

}