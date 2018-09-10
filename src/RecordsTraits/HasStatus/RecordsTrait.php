<?php

namespace ByTIC\Records\SmartProperties\RecordsTraits\HasStatus;

use ByTIC\Common\Records\Properties\Statuses\Generic as GenericStatus;
use Exception;

/**
 * Class RecordsTrait
 * @package ByTIC\Records\SmartProperties\RecordsTraits\HasStatus
 */
trait RecordsTrait
{
    use \ByTIC\Records\SmartProperties\RecordsTraits\AbstractTrait\RecordsTrait;
    use \ByTIC\Records\SmartProperties\RecordsTraits\HasSmartProperties\RecordsTrait;

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
     * @return null|string
     */
    public function getStatusesDirectory()
    {
        return $this->getSmartPropertyDefinition('Status')->getItemsDirectory();
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
