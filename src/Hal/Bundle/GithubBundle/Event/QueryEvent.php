<?php
namespace Hal\Bundle\GithubBundle\Event;
use Symfony\Component\EventDispatcher\Event;
use Doctrine\ORM\QueryBuilder;

class QueryEvent extends Event implements EventInterface
{

    private $queryBuilder;

    function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }
}