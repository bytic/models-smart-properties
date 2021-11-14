<?php

namespace ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasSmartProperties;

use ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties\RecordsTrait;
use Nip\Records\RecordManager as AbstractRecords;

/**
 * Class Records
 * @package ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasSmartProperties
 */
class Records extends AbstractRecords
{
    use RecordsTrait;

    public function registerSmartProperties()
    {
        $this->registerSmartProperty('status');
        $this->registerSmartProperty('multi_status');
        $this->registerSmartProperty('registration_status');
    }

    public function getDefaultRegistrationStatus(): string
    {
        return 'unregistered';
    }

    public function getMultiStatusItemsDirectory(): array
    {
        return [
            __NAMESPACE__ . '\RegistrationStatuses' => __DIR__ . '/RegistrationStatuses',
            __NAMESPACE__ . '\Statuses' => __DIR__ . '/Statuses',
        ];
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @return string
     */
    public function getModelNamespace()
    {
        return 'ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasSmartProperties\\';
    }
}
