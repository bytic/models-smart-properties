<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasStatus;

use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic;
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
    use PropertyRecordTrait;
}
