<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties;

use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic as PropertyValue;
use ByTIC\Models\SmartProperties\Properties\Definitions\Definition;
use ByTIC\Models\SmartProperties\Properties\PropertiesRegistry;
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
     * @param $name
     * @return PropertyValue
     */
    public function getSmartProperty($name)
    {
        if ($this->getManager()->hasSmartPropertyDefinition($name) === false) {
            return null;
        }
        $definition = $this->getManager()->getSmartPropertyDefinition($name);
        return PropertiesRegistry::getWithInit($this, $definition, function () use ($definition) {
            return $this->getNewSmartPropertyFromDefinition($definition);
        });
    }

    /**
     * @param $name
     * @param $value
     * @return bool
     * @throws \Exception
     */
    public function updateSmartProperty($name, $value)
    {
        if (empty($value)) {
            return false;
        }

        $newStatus = $this->getNewSmartPropertyFromValue($name, $value);
        $this->setSmartProperty($name, $newStatus);
        $return = $newStatus->update();
        return $return;
    }

    /**
     * @param Definition $definition
     * @return PropertyValue
     * @internal Do not use
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
     * @internal Do not use
     */
    public function getSmartPropertyValueFromDefinition($definition)
    {
        $field = $definition->getField();
        $value = $this->getAttributeFromArray($field);
        if (empty($value)) {
            $value = $definition->getDefaultValue();
            $this->setAttribute($field, $value);
        }

        return $value;
    }

    /**
     * @param $name
     * @param $value
     * @return PropertyValue
     * @throws \Exception
     * @internal Do not use
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
        if (empty($value)) {
            return;
        }
        $definition = $this->getManager()->getSmartPropertyDefinition($name);
        $field = $definition->getField();

        if (is_string($value)) {
            $value = $this->getNewSmartPropertyFromValue($name, $value);
        }
        $currentProperty = $this->getSmartProperty($name);
        if ($currentProperty->getName() === $value->getName()) {
            return;
        }

        $this->setPropertyValue($field, $value->getName());
        PropertiesRegistry::set($this, $definition, $value);
    }
}
