<?php

namespace ByTIC\Models\SmartProperties\Definitions\Definition;

use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic;
use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic as Property;
use ByTIC\Models\SmartProperties\Properties\PropertiesFactory;
use Exception;

/**
 * Trait HasProperties
 * @package ByTIC\Models\SmartProperties\Definitions\Definition
 */
trait HasProperties
{
    protected $items = null;
    protected $itemsAliases = [];

    /**
     * @param $name
     *
     * @return Property
     * @throws Exception
     */
    public function getItem($name): Property
    {
        $items = $this->getItems();
        if (!$this->hasItem($name)) {
            throw new Exception(
                'Bad Item [' . $name . '] for smart property 
                [' . $this->getManager()->getController() . '::' . $this->getName() . ']
                [' . implode(',', array_keys($items)) . ']'
            );
        }
        if (isset($this->itemsAliases[$name])) {
            $name = $this->itemsAliases[$name];
        }
        return $items[$name];
    }

    /**
     * @return null|Property[]
     */
    public function getItems(): ?array
    {
        $this->checkBuild();

        if ($this->items == null) {
            $this->initItems();
        }

        return $this->items;
    }

    public function initItems()
    {
        $names = $this->getPlaces();
        $this->items = [];
        foreach ($names as $name) {
            $object = $this->newProperty($name);
            $this->addItem($object);
        }
    }

    /**
     * @param string $type
     *
     * @return Property
     */
    public function newProperty($type = null): Property
    {
        $type = $type ?: $this->getDefaultValue();
        return PropertiesFactory::forDefinition($this, $type);
    }

    /**
     * @param null $type
     *
     * @return string
     */
    public function getPropertyClass($type = null): string
    {
        $type = $type ?: $this->getDefaultValue();
        $type = str_replace(DIRECTORY_SEPARATOR, '\\', $type);

        return $this->getPropertyItemsRootNamespace() . inflector()->classify($type);
    }

    /**
     * @param Generic $object
     */
    public function addItem(Property $object)
    {
        $this->items[$object->getName()] = $object;
        $this->addPlace($object->getName());
        $aliases = $object->getAliases();
        foreach ($aliases as $alias) {
            $this->itemsAliases[$alias] = $object->getName();
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasItem($name): bool
    {
        $items = $this->getItems();

        return isset($items[$name]) || isset($this->itemsAliases[$name]);
    }


}
