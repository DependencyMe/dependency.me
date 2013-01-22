<?php

namespace Hal\Bundle\ReleaseBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HalReleaseBundle extends Bundle
{


    public function boot()
    {
        parent::boot();
        //$platform = $this->container->get('doctrine.orm.entity_manager')->getConnection()->getDatabasePlatform();
        //$platform->registerDoctrineTypeMapping('requirementstatus', 'string');
        \Doctrine\DBAL\Types\Type::addType('requirementstatus', '\Hal\Bundle\ReleaseBundle\Dbal\Types\EnumRequirementStatusType');
        \Doctrine\DBAL\Types\Type::addType('constraint', '\Hal\Bundle\ReleaseBundle\Dbal\Types\ConstraintType');
        \Doctrine\DBAL\Types\Type::addType('version', '\Hal\Bundle\ReleaseBundle\Dbal\Types\ReleaseType');


        $eventDispatcher = $this->container->get('event_dispatcher');

        $eventDispatcher->addSubscriber(new \Hal\Bundle\ReleaseBundle\Event\Suscriber\Github\QuerySuscriber());
    }

}
