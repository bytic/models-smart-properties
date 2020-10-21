<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasTypes;

use ByTIC\Models\SmartProperties\Properties\Statuses\Generic as GenericStatus;
use ByTIC\Models\SmartProperties\Properties\Types\Generic as GenericType;

/**
 * Trait PropertyRecordsTrait
 * @package ByTIC\Models\SmartProperties\RecordsTraits\HasTypes
 */
trait PropertyRecordsTrait
{
    /**
     * Get property of a type by name
     *
     * @param string $name Type name
     *
     * @return array
     */
    public function getTypeProperty($name)
    {
        return $this->getSmartPropertyValues('Type', $name);
    }

    /**
     * Get all the types array
     *
     * @return GenericType[]|null
     */
    public function getTypes()
    {
        return $this->getSmartPropertyItems('Type');
    }

    /**
     * @param string $name
     * @return GenericStatus
     * @throws Exception
     */
    public function getType($name = null)
    {
        return $this->getSmartPropertyItem('Type', $name);
    }

    protected function registerSmartPropertyType()
    {
        $this->registerSmartProperty('type');
    }
}