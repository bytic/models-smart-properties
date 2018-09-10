<?php

namespace ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasSmartProperties;

use ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties\RecordTrait;
use Nip\Records\Record as AbstractRecord;

/**
 * Class Record
 * @package ByTIC\Common\Tests\Fixtures\Unit\Recrods\Traits\HasSmartProperties
 *
 * @property string $status
 * @property string $registration_status
 */
class Record extends AbstractRecord
{
    use RecordTrait;

    public function getRegistry()
    {
    }

    public function saveRecord()
    {
    }
}
