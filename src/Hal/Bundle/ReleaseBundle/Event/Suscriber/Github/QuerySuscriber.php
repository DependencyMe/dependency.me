<?php

namespace Hal\Bundle\ReleaseBundle\Event\Suscriber\Github;

use Hal\Bundle\GithubBundle\Event\GithubEvent;
use Hal\Bundle\GithubBundle\Event\QueryEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class QuerySuscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            GithubEvent::PREPARE_QUERY_REPOSITORY => array('onGithubQueryPrepare', 0),
            GithubEvent::PREPARE_QUERY_OWNER => array('onGithubQueryPrepare', 0),
            GithubEvent::PREPARE_QUERY_BRANCHE => array('onGithubQueryPrepare', 0),
        );
    }

    public function onGithubQueryPrepare(QueryEvent $queryEvent)
    {
        $queryEvent->getQueryBuilder()
            ->leftJoin('b.declaration', 'd')
            ->leftJoin('d.requirements', 'req')
            ->leftJoin('req.package', 'p')
            ->addSelect('d, req, p');
    }

}
