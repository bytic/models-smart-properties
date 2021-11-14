<?php

namespace ByTIC\Models\SmartProperties\Definitions\Definition;

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
        $this->checkBuild();
        return $this->places;
    }

    /**
     * @param array $places
     */
    public function setPlaces(array $places): void
    {
        $this->places = $places;
    }

    public function addPlace()
    {
        $this->places = array_unique(array_merge($this->places, func_get_args()));
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
