<?php

namespace ByTIC\Models\SmartProperties\Tests\RecordsTraits\HasTypes;

use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic;
use ByTIC\Models\SmartProperties\Tests\AbstractTest;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\Record;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\Records;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\Types\Individual;

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

    public function test_setType_string()
    {
        $this->object->setType('individual');
        $type = $this->object->getType();

        self::assertInstanceOf(Generic::class, $type);
        self::assertInstanceOf(Individual::class, $type);
        self::assertSame('individual', $type->getName());
        $data = $this->object->toArray();

        self::assertSame('individual', $data['type']);
    }

    public function test_setType_string_sameType()
    {
        $this->object->setType('individual');
        $type = $this->object->getType();
        $type->singleton = true;

        self::assertInstanceOf(Individual::class, $type);
        self::assertSame('individual', $type->getName());

        $this->object->setType('individual');
        $type = $this->object->getType();

        self::assertTrue($type->singleton);
    }

    public function test_setType_object()
    {
        $this->object->setType(new Individual());
        $type = $this->object->getType();

        self::assertInstanceOf(Generic::class, $type);
        self::assertInstanceOf(Individual::class, $type);
        self::assertSame('individual', $type->getName());
        $data = $this->object->toArray();

        self::assertSame('individual', $data['type']);
    }

    public function test_magic_setter()
    {
        $this->object->type = 'individual';

        $type = $this->object->getType();
        self::assertInstanceOf(Generic::class, $type);
        self::assertInstanceOf(Individual::class, $type);
        self::assertSame('individual', $type->getName());

        $data = $this->object->toArray();
        self::assertSame('individual', $data['type']);
    }

    protected function setUp() : void
    {
        parent::setUp();
        $this->object = new Record();

        $manager = new Records();
        $this->object->setManager($manager);
    }
}
