<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasStatus;

use ByTIC\Models\SmartProperties\Properties\Statuses\Generic;
use ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties\RecordTrait as HasSmartPropertiesRecord;
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
    use HasSmartPropertiesRecord;

    /**
     * @return Generic
     */
    public function getStatus()
    {
        return $this->getSmartProperty('Status');
    }

    /**
     * @param $status
     * @return Generic
     */
    public function getNewStatus($status)
    {
        return $this->getNewSmartPropertyFromValue('Status', $status);
    }

    /**
     * @param bool $status
     * @return bool|void
     */
    public function updateStatus($status = false)
    {
        return $this->updateSmartProperty('Status', $status);
    }
}
