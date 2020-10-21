<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasStatus;

use ByTIC\Models\SmartProperties\Properties\Statuses\Generic as GenericStatus;
use Exception;

/**
 * Trait PropertyRecordsTrait
 * @package ByTIC\Models\SmartProperties\RecordsTraits\HasStatus
 */
trait PropertyRecordsTrait
{
    /**
     * @param $name
     * @return array
     */
    public function getStatusProperty($name): array
    {
        return $this->getSmartPropertyValues('Status', $name);
    }

    /**
     * @return null|GenericStatus[]
     */
    public function getStatuses(): ?array
    {
        return $this->getSmartPropertyItems('Status');
    }

    /**
     * @param string $name
     * @return GenericStatus
     * @throws Exception
     */
    public function getStatus($name = null): GenericStatus
    {
        return $this->getSmartPropertyItem('Status', $name);
    }

    protected function registerSmartPropertyStatus()
    {
        $this->registerSmartProperty('status');
    }
}
