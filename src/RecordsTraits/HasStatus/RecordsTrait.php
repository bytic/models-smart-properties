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
    use PropertyRecordsTrait;

    protected function registerSmartProperties()
    {
        $this->registerSmartPropertyStatus();
    }
}
