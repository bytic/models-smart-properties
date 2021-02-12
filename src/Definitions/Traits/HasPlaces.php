<?php

namespace ByTIC\Models\SmartProperties\Definitions\Traits;

/**
 * Trait HasPlaces
 * @package ByTIC\Models\SmartProperties\Definitions\Traits
 */
trait HasPlaces
{
    protected $places = [];

    /**
     * @return array
     */
    public function getPlaces(): array
    {
        return $this->places;
    }

    /**
     * @param array $places
     */
    public function setPlaces(array $places): void
    {
        $this->places = $places;
    }

    /**
     * @return array
     * @deprecated use getPlaces
     */
    public function getItemsNames()
    {
        return $this->getPlaces();
    }
}
