<?php

namespace Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\View;

use Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\HalContext;
use Behat\Behat\Context\Step\Given;
use Behat\Behat\Context\Step\When;
use Behat\Behat\Context\Step\Then;

class WebContext extends HalContext
{

    /**
     * @When /^I want to obtain the list of the repositories of "([^"]*)"$/
     */
    public function iWantToObtainTheListOfTheRepositoriesOf($owner)
    {
        return array(
            new When(sprintf('I go to "repository/owner/"', $owner))
        );
    }

    /**
     * @When /^I want to obtain the list of branches of the repository "([^"]*)"$/
     */
    public function iWantToObtainTheListOfBranchesOfTheRepository($repository)
    {
        list($owner, $repository) = explode('/', $repository);
        return array(
            new When(sprintf('I go to "repository/owner/"', $owner))
        );
    }

    /**
     * @When /^I want to know the state of the dependency "([^"]*)" of branche "([^"]*)" of "([^"]*)"$/
     */
    public function iWantToKnowTheStateOfTheDependencyOfBrancheOf($dependency, $branche, $repo)
    {
        list($owner, $repository) = explode('/', $repo);
        return array(
            new When(sprintf('I go to "/repository/branche/%s/%s/%s"', $owner, $repository, $branche))
        );
    }

}