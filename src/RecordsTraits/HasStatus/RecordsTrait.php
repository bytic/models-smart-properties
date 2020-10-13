<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasStatus;

use ByTIC\Models\SmartProperties\Properties\Statuses\Generic as GenericStatus;
use Exception;

/**
 * Class RecordsTrait
 * @package ByTIC\Models\SmartProperties\RecordsTraits\HasStatus
 */
trait RecordsTrait
{
    use \ByTIC\Models\SmartProperties\RecordsTraits\AbstractTrait\RecordsTrait;
    use \ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties\RecordsTrait;

    /**
     * @param $name
     * @return array
     */
    public function getStatusProperty($name)
    {
        return $this->getSmartPropertyValues('Status', $name);
    }

    /**
     * @return null|GenericStatus[]
     */
    public function getStatuses()
    {
        return $this->getSmartPropertyItems('Status');
    }

    /**
     * @param string $name
     * @return GenericStatus
     * @throws Exception
     */
    public function getStatus($name = null)
    {
        return $this->getSmartPropertyItem('Status', $name);
    }

    protected function registerSmartProperties()
    {
        $this->registerSmartProperty('status');
    }
}
