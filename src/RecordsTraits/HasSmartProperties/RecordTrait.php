<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties;

use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic as PropertyValue;
use ByTIC\Models\SmartProperties\Properties\Definitions\Definition;
use Nip\Records\RecordManager;

/**
 * Class RecordTrait
 * @package ByTIC\Models\SmartProperties\RecordsTraits\HasStatus
 *
 * @property string $status
 * @method RecordManager|RecordsTrait getManager()
 *
 */
trait RecordTrait
{
    use \ByTIC\Models\SmartProperties\RecordsTraits\AbstractTrait\RecordTrait;

    /**
     * @var PropertyValue[]
     */
    protected $smartProperties = [];

    /**
     * @param $name
     * @return PropertyValue
     */
    public function getSmartProperty($name)
    {
        $this->checkSmartProperty($name);

        return $this->smartProperties[$name];
    }

    /**
     * @param string $name
     */
    public function checkSmartProperty($name)
    {
        if (!isset($this->smartProperties[$name])) {
            $this->initSmartProperty($name);
        }
    }

    /**
     * @param string $name
     */
    public function initSmartProperty($name)
    {
        if ($this->getManager()->hasSmartPropertyDefinition($name)) {
            $definition = $this->getManager()->getSmartPropertyDefinition($name);
            $property = $this->getNewSmartPropertyFromDefinition($definition);
            $this->setSmartProperty($name, $property);
        }
    }

    /**
     * @param Definition $definition
     * @return PropertyValue
     */
    public function getNewSmartPropertyFromDefinition($definition)
    {
        $name = $definition->getName();
        $value = $this->getSmartPropertyValueFromDefinition($definition);

        return $this->getNewSmartPropertyFromValue($name, $value);
    }

    /**
     * @param Definition $definition
     * @return mixed
     */
    public function getSmartPropertyValueFromDefinition($definition)
    {
        $field = $definition->getField();
        $value = $this->getAttributeFromArray($field);
        if ($value === null) {
            $value = $definition->getDefaultValue();
        }

        return $value;
    }

    /**
     * @param $name
     * @param $value
     * @return PropertyValue
     * @throws \Exception
     */
    public function getNewSmartPropertyFromValue($name, $value)
    {
        $object = clone $this->getManager()->getSmartPropertyItem($name, $value);
        $object->setItem($this);

        return $object;
    }

    /**
     * @param string $name
     * @param PropertyValue|string $value
     * @throws \Exception
     */
    protected function setSmartProperty($name, $value)
    {
        $definition = $this->getManager()->getSmartPropertyDefinition($name);
        $field = $definition->getField();
        if ($value instanceof PropertyValue) {
            $this->setDataValue($field, $value->getName());
            $this->smartProperties[$name] = $value;
            return;
        }
        if (!empty($value)) {
            $currentProperty = $this->getSmartProperty($name);
            if (is_object($currentProperty) && $currentProperty->getName() === $value) {
                return;
            }
            $this->setDataValue($field, $value);
            $this->smartProperties[$name] = $this->getNewSmartPropertyFromValue($name, $value);
        }
    }

    /**
     * @param $name
     * @param $value
     * @return bool
     * @throws \Exception
     */
    public function updateSmartProperty($name, $value)
    {
        if (!empty($value)) {
            $newStatus = $this->getNewSmartPropertyFromValue($name, $value);
            $this->setSmartProperty($name, $newStatus);
            $return = $newStatus->update();
            return $return;
        }

        return false;
    }
}
