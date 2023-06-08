<?php

namespace ByTIC\Models\SmartProperties\Tests\RecordsTraits\HasStatus;

use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasStatus\Record;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasStatus\Records;
use ByTIC\Models\SmartProperties\Tests\AbstractTest;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasStatus\Statuses\Allocated;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasStatus\Statuses\Applicant;

/**
 * Class TraitsTest
 * @package ByTIC\Models\SmartProperties\Tests\RecordsTraits\HasStatus
 */
class RecordTraitTest extends AbstractTest
{
    /**
     * @var Record
     */
    private $object;

    public function testGetStatusWithoutValue()
    {
        $status = $this->object->getStatus();
        self::assertInstanceOf(Generic::class, $status);
        self::assertSame('allocated', $status->getName());

        $data = $this->object->toArray();
        self::assertSame('allocated', $data['status']);
    }

    public function testGetStatusWithValue()
    {
        $this->object->status = 'applicant';

        $status = $this->object->getStatus();
        self::assertInstanceOf(Generic::class, $status);
        self::assertSame('applicant', $status->getName());

        $data = $this->object->toArray();
        self::assertSame('applicant', $data['status']);
    }

    /**
     * @param $status
     * @param $check
     * @param $result
     * @dataProvider data_isInStatus
     */
    public function test_isInStatus($status, $check, $result)
    {
        $this->object->status = $status;
        self::assertSame($result, $this->object->isInStatus($check));
    }

    public function data_isInStatus()
    {
        return [
            ['applicant', 'applicant', true],
            [Allocated::NAME, Allocated::class, true],
            [Applicant::NAME, Allocated::class, false],
            [Allocated::NAME, [Applicant::class, Allocated::NAME], true],
        ];
    }
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = \Mockery::mock(Record::class)->makePartial();

        $manager = new Records();
        $this->object->shouldReceive('getManager')->andReturn($manager);
    }
}
