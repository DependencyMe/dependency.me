<?php

namespace Hal\Bundle\ReleaseWebBundle\Features\Context\Hal;

/**
 * Persister
 */
interface PersisterInterface
{

    public function reset();

    public function save($object);

    public function load($type, $value);

    public function create($type, $value);

    public function loadOrCreate($type, $value);

    public function setEntityFromArray(&$object, array $array);

    public function buildAttribute($object, $name, $value);
}