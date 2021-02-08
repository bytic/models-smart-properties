<?php

namespace ByTIC\Models\SmartProperties\Properties\Definitions;

use ByTIC\Models\SmartProperties\Definitions\Traits\HasName;
use ByTIC\Models\SmartProperties\Definitions\Traits\HasPlaces;
use ByTIC\Models\SmartProperties\Definitions\Traits\Serializable;
use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic;
use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic as Property;
use ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties\RecordsTrait;
use Exception;
use Nip\Records\RecordManager;

/**
 * Class Definition
 * @package ByTIC\Models\SmartProperties\Properties\Definitions
 */
class Definition implements \Serializable
{
    use HasName;
    use HasPlaces;
    use Serializable;

    /**
     * @var RecordManager|RecordsTrait
     */
    protected $manager;


    /**
     * @var string
     */
    protected $label = null;

    /**
     * @var string
     */
    protected $field;

    protected $items = null;
    protected $itemsAliases = [];

    protected $defaultValue = null;

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
     * @return string|null
     */
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return RecordManager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param RecordManager|RecordsTrait $manager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return string
     */
    public function getLabel(): ?string
    {
        if ($this->label === null) {
            $this->initLabel();
        }

        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    protected function initLabel()
    {
        $name = inflector()->pluralize($this->getName());
        $this->setLabel($name);
    }

    /**
     * @param string $type
     *
     * @return Property
     */
    public function newProperty($type = null): Property
    {
        $className = $this->getPropertyClass($type);
        $object = new $className();
        /** @var Property $object */
        $object->setManager($this->getManager());
        $object->setField($this->getField());
        $object->setNamespace($this->getPropertyItemsRootNamespace());
        return $object;
    }

    /**
     * @param null $type
     *
     * @return string
     */
    public function getPropertyClass($type = null): string
    {
        $type = $type ? $type : $this->getDefaultValue();
        $type = str_replace(DIRECTORY_SEPARATOR, '\\', $type);

        return $this->getPropertyItemsRootNamespace() . inflector()->classify($type);
    }

    /**
     * @return string
     */
    public function getDefaultValue(): ?string
    {
        if ($this->defaultValue === null) {
            $this->initDefaultValue();
        }

        return $this->defaultValue;
    }

    /**
     * @param null $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @param Generic $object
     */
    protected function addItem(Property $object)
    {
        $this->items[$object->getName()] = $object;
        $aliases = $object->getAliases();
        foreach ($aliases as $alias) {
            $this->itemsAliases[$alias] = $object->getName();
        }
    }

    protected function initDefaultValue()
    {
        $managerDefaultValue = $this->getDefaultValueFromManager();
        if ($managerDefaultValue && $this->hasItem($managerDefaultValue)) {
            $defaultValue = $managerDefaultValue;
        } else {
            $keys = array_keys($this->getItems());
            $defaultValue = reset($keys);
        }
        $this->setDefaultValue($defaultValue);
    }

    /**
     * @return bool|string
     */
    protected function getDefaultValueFromManager()
    {
        $method = 'getDefault' . $this->getName();
        if (method_exists($this->getManager(), $method)) {
            return $this->getManager()->{$method}();
        }

        return false;
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

    /**
     * @return string
     */
    protected function getPropertyItemsRootNamespace(): string
    {
        $manager = $this->getManager();
        $method = 'get' . $this->getName() . 'ItemsRootNamespace';
        if (method_exists($manager, $method)) {
            return $manager->{$method}();
        }

        $method = 'get' . $this->getName() . 'Namespace';
        if (method_exists($manager, $method)) {
            return $manager->{$method}();
        }

        return $manager->getModelNamespace() . $this->getLabel() . '\\';
    }

    /**
     * @param $name
     *
     * @return array
     */
    public function getValues($name): array
    {
        $return = [];
        $items = $this->getItems();

        foreach ($items as $type) {
            $method = 'get' . ucfirst($name);
            if (method_exists($type, $method)) {
                $return[] = $type->$method();
            } else {
                $return[] = $type->{$name};
            }
        }

        return $return;
    }
}
