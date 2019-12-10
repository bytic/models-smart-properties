<?php

namespace ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes;

use ByTIC\Models\SmartProperties\RecordsTraits\HasTypes\RecordTrait;
use Nip\Records\Record as AbstractRecord;

/**
 * Class Record
 * @package ByTIC\Common\Tests\Fixtures\Unit\Recrods\Traits\HasTypes
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
}
