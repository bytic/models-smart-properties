<?php

namespace ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\PdfLetters;

use ByTIC\Models\SmartProperties\RecordsTraits\HasTypes\RecordsTrait;
use Nip\Records\RecordManager as AbstractRecords;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Records
 * @package ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\PdfLetters
 */
class Records extends AbstractRecords
{
    use RecordsTrait;
    use SingletonTrait;


    protected function registerSmartPropertyType()
    {
        $this->registerSmartProperty('field', 'Type');
    }

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
        return 'ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\PdfLetters\\';
    }
}
