<?php

namespace Hal\Bundle\ReleaseWebBundle\Features\Context\Hal;

use Behat\Gherkin\Node\TableNode;

/**
 * Persister
 */
abstract class PersisterAbstract implements PersisterInterface
{

    protected $container;
    protected $em;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    public function reset()
    {
        $this->em->close();
        $this->container->get('doctrine')->resetEntityManager();
        $this->container->set('doctrine.orm.entity_manager', null);
        $this->container->set('doctrine.orm.default_entity_manager', null);
        $this->em = $this->container->get('doctrine')->getEntityManager();
        $this->container->get('doctrine')->resetEntityManager();
    }

    public function setEntityFromArray(&$object, array $array)
    {
        foreach ($array as $name => $value) {
            if (method_exists($object, 'set' . ucfirst($name))) {
                $value = $this->buildAttribute($object, $name, $value);
                call_user_func(array($object, 'set' . ucfirst($name)), $value);
            }
        }
        return $object;
    }

    public function buildAttribute($object, $name, $value)
    {
        return $value;
    }

}