<?php

namespace ByTIC\Models\SmartProperties\Tests\RecordsTraits\HasStatus;

use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasStatus\Records;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasStatus\Statuses\Allocated;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasStatus\Statuses\Applicant;
use ByTIC\Models\SmartProperties\Tests\AbstractTest;

/**
 * Class TraitsTest
 * @package ByTIC\Models\SmartProperties\Tests\Payments\Methods
 */
class RecordsTraitTest extends AbstractTest
{
    /**
     * @var Records
     */
    private $object;

    public function testGetSmartPropertiesDefinitions()
    {
        $definitions = $this->object->getSmartPropertiesDefinitions();
        self::assertCount(1, $definitions);
    }

    public function testGetStatusesDirectory()
    {
        $directory = $this->object->getStatusesDirectory();

        self::assertStringEndsWith(
            str_replace('/', DIRECTORY_SEPARATOR, 'RecordsTraits/HasStatus/Statuses'),
            $directory
        );
    }

    public function testGetStatuses()
    {
        $statuses = $this->object->getStatuses();
        self::assertCount(2, $statuses);
        self::assertInstanceOf(Allocated::class, $statuses['allocated']);
        self::assertInstanceOf(Applicant::class, $statuses['applicant']);
    }

    public function testGetStatusProperty()
    {
        $values = $this->object->getStatusProperty('name');
        self::assertSame(['allocated', 'applicant'], $values);
    }

    public function testGetStatus()
    {
        $status = $this->object->getStatus('allocated');
        self::assertInstanceOf(Allocated::class, $status);
    }


    protected function setUp(): void
    {
        parent::setUp();
        $this->object = new Records();
    }
}
