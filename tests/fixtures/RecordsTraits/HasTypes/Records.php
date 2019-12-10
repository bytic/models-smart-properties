<?php

namespace ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes;

use ByTIC\Models\SmartProperties\RecordsTraits\HasTypes\RecordsTrait;
use Nip\Records\RecordManager as AbstractRecords;

/**
 * Class Records
 * @package ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes
 */
class Records extends AbstractRecords
{
    use RecordsTrait;

    /** @noinspection PhpMissingParentCallCommonInspection
     * @return string
     */
    public function getModelNamespace()
    {
        return 'ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\\';
    }
}
