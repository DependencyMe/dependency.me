<?php
namespace Hal\Bundle\GithubBundle\Event;

final class GithubEvent
{
    const PREPARE_QUERY_OWNER = 'github.owner.prepare_query';
    const PREPARE_QUERY_REPOSITORY = 'github.repository.prepare_query';
    const PREPARE_QUERY_BRANCHE = 'github.branche.prepare_query';

}