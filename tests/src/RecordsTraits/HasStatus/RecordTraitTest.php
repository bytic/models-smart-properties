<?php

namespace ByTIC\Models\SmartProperties\Tests\RecordsTraits\HasStatus;

use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasStatus\Record;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasStatus\Records;
use ByTIC\Models\SmartProperties\Tests\AbstractTest;

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

    protected function setUp() : void
    {
        parent::setUp();
        $this->object = new Record();

        $manager = new Records();
        $this->object->setManager($manager);
    }
}
