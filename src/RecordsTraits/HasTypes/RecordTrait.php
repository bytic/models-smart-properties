<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasTypes;

use ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties\RecordTrait as HasSmartPropertiesRecord;

/**
 * Trait RecordTrait
 *
 * @property $type
 *
 * @method RecordsTrait getManager
 *
 * @package ByTIC\Models\SmartProperties\RecordsTraits\HasTypes
 */
trait RecordTrait
{
    use \ByTIC\Models\SmartProperties\RecordsTraits\AbstractTrait\RecordTrait;
    use HasSmartPropertiesRecord;
    use PropertyRecordTrait;
}
