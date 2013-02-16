<?php

namespace Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\Release;

use Behat\Behat\Context\Step\Then;
use Behat\Behat\Context\Step\When;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Hal\Bundle\GithubBundle\Entity\Repository;
use Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\HalContext;

class RepositoryContext extends HalContext
{

    /**
     * @Given /^"([^"]*)" has the following repositories:$/
     */
    public function hasTheFollowingRepositories($owner, TableNode $repositories)
    {
        $persister = $this->getPersister();
        $owner = $persister->createOwnerFromArray(array('login' => $owner));
        $persister->save($owner);
        $repositories = $persister->createRepositoriesFromTableNode($repositories, $owner);
        $persister->save($repositories);
    }

    /**
     * @Then /^I should be informed that the following repositories exist:$/
     */
    public function iShouldBeInformedThatTheFollowingRepositoriesExist(TableNode $repositories)
    {
        $steps = array();
        foreach ($repositories as $repository) {
            $steps[] = new Then(sprintf('I should see "%s"', $repository['name']));
        }
        return $steps;
    }

    /**
     * @Then /^I should not be informed that the following repositories exist:$/
     */
    public function iShouldNotBeInformedThatTheFollowingRepositoriesExist(TableNode $repositories)
    {
        $steps = array();
        foreach ($repositories as $repository) {
            $steps[] = new Then(sprintf('I should not see "%s"', $repository['name']));
        }
        return $steps;
    }

    /**
     * @Then /^I should be informed that there are "([^"]*)" branches:$/
     */
    public function iShouldBeInformedThatThereAreBranches($nb, TableNode $branches)
    {
        $steps = array();
        foreach ($branches as $branche) {
            $steps[] = new Then(sprintf('I should see "%s"', $branche['name']));
        }
        return $steps;
    }

}