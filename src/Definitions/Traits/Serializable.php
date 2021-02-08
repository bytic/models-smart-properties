<?php

namespace ByTIC\Models\SmartProperties\Definitions\Traits;

/**
 * Trait Serializable
 * @package ByTIC\Models\SmartProperties\Definitions\Traits
 */
trait Serializable
{
    public function serialize(): array
    {
        return ['name', 'label', 'places'];
    }

    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }
}