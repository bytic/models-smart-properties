<?php

namespace ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes;

use ByTIC\Models\SmartProperties\RecordsTraits\HasTypes\RecordsTrait;
use Nip\Records\RecordManager as AbstractRecords;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Records
 * @package ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes
 */
class Records extends AbstractRecords
{
    use RecordsTrait;
    use SingletonTrait;

    /**
     * @inheritDoc
     */
    public function getTypesDirectory()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'Types';
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @return string
     */
    public function getModelNamespace()
    {
        return 'ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\\';
    }
}
