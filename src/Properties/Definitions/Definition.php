<?php

namespace ByTIC\Models\SmartProperties\Properties\Definitions;

use ByTIC\Common\Records\Traits\HasSmartProperties\RecordsTrait;
use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic as Property;
use Exception;
use Nip\Records\RecordManager;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Class Definition
 * @package ByTIC\Models\SmartProperties\Properties\Definitions
 */
class Definition
{
    use Traits\HasItemsDirectoryTrait;

    /**
     * @var RecordManager|RecordsTrait
     */
    protected $manager;

    /**
     * @var string
     */
    protected $name = null;

    /**
     * @var string
     */
    protected $label = null;

    /**
     * @var string
     */
    protected $field;

    protected $items = null;

    protected $defaultValue = null;

    /**
     * @param $name
     *
     * @return Property
     * @throws Exception
     */
    public function getItem($name)
    {
        $items = $this->getItems();
        if (! $this->hasItem($name)) {
            throw new Exception(
                'Bad Item [' . $name . '] for smart property 
                [' . $this->getManager()->getController() . '::' . $this->getName() . ']
                [' . implode(',', array_keys($items)) . ']'
            );
        }

        return $items[$name];
    }

    /**
     * @return null|Property[]
     */
    public function getItems()
    {
        if ($this->items == null) {
            $this->initItems();
        }

        return $this->items;
    }

    public function initItems()
    {
        $names       = $this->getItemsNames();
        $this->items = [];
        foreach ($names as $name) {
            if (! $this->isAbstractItemName($name)) {
                $object                          = $this->newStatus($name);
                $this->items[$object->getName()] = $object;
            }
        }
    }

    /**
     * @return array
     */
    public function getItemsNames()
    {
        $names = $this->getItemsNamesFromManager();

        return $names ? $names : $this->getItemsNamesFromFiles();
    }

    /**
     * @return array|boolean
     */
    protected function getItemsNamesFromManager()
    {
        $methodName = 'get' . $this->getName() . 'Names';
        if (method_exists($this->getManager(), $methodName)) {
            return $this->getManager()->$methodName();
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        if ($this->name === null) {
            $this->initName();
        }

        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    protected function initName()
    {
        $name = inflector()->classify($this->getField());
        $this->setName($name);
    }

    /**
     * @return mixed
     */
    public function getField()
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
     * @return array
     */
    protected function getItemsNamesFromFiles()
    {
        $directory = $this->getItemsDirectory();
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->getItemsDirectory()));
        $names = [];
        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }
            $name = str_replace($directory, '', $file->getPathname());
            $name = str_replace('.php', '', $name);
            $names[] = trim($name, DIRECTORY_SEPARATOR . '\\');
        }

        return array_unique($names);
    }


    /**
     * @return string
     */
    public function getLabel()
    {
        if ($this->label === null) {
            $this->initLabel();
        }

        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    protected function initLabel()
    {
        $name = inflector()->pluralize($this->getName());
        $this->setLabel($name);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function isAbstractItemName($name)
    {
        if (in_array($name, ['Abstract', 'Generic'])) {
            return true;
        }
        if (strpos($name, 'Abstract') === 0) {
            return true;
        }
        if (strpos($name, '\Abstract') !== false) {
            return true;
        }

        return false;
    }

    /**
     * @param string $type
     *
     * @return Property
     */
    public function newStatus($type = null)
    {
        $className = $this->getItemClass($type);
        $object    = new $className();
        /** @var Property $object */
        $object->setManager($this->getManager());
        $object->setField($this->getField());

        return $object;
    }

    /**
     * @param null $type
     *
     * @return string
     */
    public function getItemClass($type = null)
    {
        $type = $type ? $type : $this->getDefaultValue();

        return $this->getPropertyItemsRootNamespace() . inflector()->classify($type);
    }

    /**
     * @return string
     */
    public function getDefaultValue()
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

    protected function initDefaultValue()
    {
        $managerDefaultValue = $this->getDefaultValueFromManager();
        if ($managerDefaultValue && $this->hasItem($managerDefaultValue)) {
            $defaultValue = $managerDefaultValue;
        } else {
            $keys         = array_keys($this->getItems());
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
     *
     * @return bool
     */
    public function hasItem($name)
    {
        $items = $this->getItems();

        return isset($items[$name]);
    }

    /**
     * @return string
     */
    protected function getPropertyItemsRootNamespace()
    {
        $method = 'get' . $this->getName() . 'ItemsRootNamespace';
        if (method_exists($this->getManager(), $method)) {
            return $this->getManager()->{$method}();
        }

        return $this->getManager()->getModelNamespace() . $this->getLabel() . '\\';
    }

    /**
     * @param $name
     *
     * @return array
     */
    public function getValues($name)
    {
        $return = [];
        $items  = $this->getItems();

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
