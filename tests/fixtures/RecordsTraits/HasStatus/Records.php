<?php

namespace ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasStatus;

use ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordsTrait;
use Nip\Records\RecordManager as AbstractRecords;

/**
 * Class Records
 * @package ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasStatus
 */
class Records extends AbstractRecords
{
    use RecordsTrait;

    /** @noinspection PhpMissingParentCallCommonInspection
     * @return string
     */
    public function getModelNamespace()
    {
        return 'ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasStatus\\';
    }
}
