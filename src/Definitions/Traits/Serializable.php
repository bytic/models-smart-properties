<?php

namespace ByTIC\Models\SmartProperties\Definitions\Traits;

use ByTIC\DataObjects\Behaviors\Serializable\SerializableTrait;

/**
 * Trait Serializable
 * @package ByTIC\Models\SmartProperties\Definitions\Traits
 */
trait Serializable
{
    use SerializableTrait;

    /**
     * @var array List of attribute names which should be stored in serialized form
     */
    protected $serializable = ['name', 'field', 'label', 'places'];

}