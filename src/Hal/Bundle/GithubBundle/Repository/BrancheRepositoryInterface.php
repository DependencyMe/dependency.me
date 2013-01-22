<?php
namespace Hal\Bundle\GithubBundle\Repository;

interface BrancheRepositoryInterface
{

    public function getByFullName($name);


}