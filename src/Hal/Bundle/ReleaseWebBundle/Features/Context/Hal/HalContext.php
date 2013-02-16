<?php

namespace Hal\Bundle\ReleaseWebBundle\Features\Context\Hal;

use Behat\Behat\Context\BehatContext;

/**
 * Feature context.
 */
class HalContext extends BehatContext
{

    private static $PERSISTER;

    public function getKernel()
    {
        return $this->getMainContext()->kernel;
    }

    public function getMink()
    {
        return $this->getMainContext()->getSubcontext('mink');
    }

    public function getContainer()
    {
        return $this->getMainContext()->kernel->getContainer();
    }

    public function getPersister()
    {
        if (is_null(self::$PERSISTER)) {
            self::$PERSISTER = new Release\Persister($this->getContainer());
        }
        return self::$PERSISTER;
    }

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        self::$PERSISTER = new Release\Persister($this->getContainer());
    }

}
