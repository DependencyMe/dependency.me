<?php

namespace Hal\Bundle\ReleaseWebBundle\Features\Context;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';
require_once __DIR__ . '/Hal/Release/OwnerContext.php';
require_once __DIR__ . '/Hal/Release/RepositoryContext.php';

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\Release\OwnerContext;
use Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\Release\BranchContext;
use Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\Release\RepositoryContext;
use Behat\CommonContexts\DoctrineFixturesContext;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

/**
 * Feature context.
 */
class FeatureContext extends BehatContext implements KernelAwareInterface
{

    public $kernel;
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
        $this->useContext('hal.owner', new OwnerContext($parameters));
        $this->useContext('hal.repository', new RepositoryContext($parameters));
        $this->useContext('hal.branch', new  BranchContext($parameters));
        $this->useContext('mink', new MinkContext($parameters));
        $this->useContext('doctrine.fixtures.context', new DoctrineFixturesContext($parameters));

        //
        // View isolation
        $classView = 'Hal\Bundle\ReleaseWebBundle\Features\Context\Hal\View\\' . ucfirst($parameters['view']) . 'Context';
        $this->useContext('view', new $classView($parameters));
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        $em = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
        $purger = new ORMPurger();
        $executor = new ORMExecutor($em, $purger);
        $executor->purge();
    }

}
