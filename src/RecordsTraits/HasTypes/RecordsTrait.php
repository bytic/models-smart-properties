<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasTypes;

use ByTIC\Models\SmartProperties\Properties\Statuses\Generic as GenericStatus;
use ByTIC\Models\SmartProperties\Properties\Types\Generic as GenericType;
use Exception;

/**
 * Class RecordsTrait
 *
 * @package ByTIC\Models\SmartProperties\RecordsTraits\HasTypes
 */
trait RecordsTrait
{
    use \ByTIC\Models\SmartProperties\RecordsTraits\AbstractTrait\RecordsTrait;
    use \ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties\RecordsTrait;

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

    protected function registerSmartProperties()
    {
        $this->registerSmartProperty('type');
    }
}
