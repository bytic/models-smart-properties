<?php

namespace ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasStatus;

use ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordTrait;
use Nip\Records\Record as AbstractRecord;

/**
 * Class Record
 * @package ByTIC\Common\Tests\Fixtures\Unit\Recrods\Traits\HasStatus
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
