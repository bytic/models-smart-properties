<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasTypes;

/**
 * Class RecordsTrait
 *
 * @package ByTIC\Models\SmartProperties\RecordsTraits\HasTypes
 */
trait RecordsTrait
{
    use \ByTIC\Models\SmartProperties\RecordsTraits\AbstractTrait\RecordsTrait;
    use \ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties\RecordsTrait;
    use PropertyRecordsTrait;

    protected function registerSmartProperties()
    {
        $this->registerSmartPropertyType();
    }
}
