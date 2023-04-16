<?php

namespace ByTIC\Models\SmartProperties\Definitions;

use ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties\RecordsTrait;
use Nip\Records\RecordManager;

/**
 * Class Definition
 * @package ByTIC\Models\SmartProperties\Definitions
 */
class Definition implements \Serializable
{
    use Definition\CanBuild;
    use Definition\HasName;
    use Definition\HasPlaces;
    use Definition\HasProperties;
    use Definition\HasPropertiesNamespaces;
    use Definition\Serializable;

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

    protected $defaultValue = null;

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
        $name = $this->getName();
        if (empty($name)) {
            return;
        }
        $name = inflector()->pluralize($name);
        $this->setLabel($name);
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
