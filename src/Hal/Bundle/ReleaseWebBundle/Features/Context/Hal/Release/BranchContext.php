<?php

namespace Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\Release;

use Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\HalContext;
use Behat\Behat\Exception\PendingException;
use Behat\Behat\Context\Step\Given;
use Behat\Behat\Context\Step\When;
use Behat\Behat\Context\Step\Then;

class BranchContext extends HalContext
{

    /**
     * @Given /^the branche "([^"]*)" of "([^"]*)" requires the package "([^"]*)" with the version "([^"]*)"$/
     */
    public function theBrancheOfRequiresThePackageWithTheVersion($branch, $repository, $package, $reqVersion)
    {
        
        
        
        $persister = $this->getPersister();
        list($owner, $repository) = explode('/', $repository);

        $owner = $persister->createOwnerFromArray(array('login' => $owner));
        $persister->save($owner);

        $repository = $persister->createRepositoryFromArray(array('name' => $repository), $owner);
        $persister->save($repository);

        $package = $persister->createPackageFromArray(array('name' => $package));
        $persister->save($package);

        $branch = $persister->createBranchFromArray(array('name' => $branch), $repository);
        $persister->save($branch);

        $requirement = $persister->createRequirementFromArray(array(
            'package' => $package
            , 'requiredVersion' => $reqVersion
                ), $branch
        );
        $persister->save($requirement);
    }

    /**
     * @Given /^the package "([^"]*)" has for current version "([^"]*)"$/
     */
    public function thePackageHasForCurrentVersion($package, $version)
    {
        $package = $this->getPersister()->createPackageFromArray(array(
            'name' => $package
            , 'currentVersion' => $version
                )
        );
        $this->getPersister()->save($package);
    }

    /**
     * @Then /^I should be informed that the branche depends to "([^"]*)"$/
     */
    public function iShouldBeInformedThatTheBrancheDependsTo($package)
    {
        return array(
            new Then(sprintf('I should see "%s"', $package))
        );
    }

    /**
     * @Given /^I should be informed that the dependency for "([^"]*)" is "([^"]*)"$/
     */
    public function iShouldBeInformedThatTheDependencyIs($package, $status)
    {
        $page = $this->getMink()->getSession()->getPage();
        $page = $this->getMink()->getSession()->getPage();
//die($page->getContent());
//exit;
        $path = sprintf('//td[contains(.,\'%s\')]/following-sibling::td/span[contains(@class, \'state\')]', $package);
        //$path = sprintf('td', $package);
        $el = $page->find('xpath', $path);
        //$el = $this->getMink()->getSession()->getDriver()->find($path);
        if (!$el) {
            throw new \Exception("Status not found for {$package} with {$path}");
        }
        //throw new PendingException();
    }

}