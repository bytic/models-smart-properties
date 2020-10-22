<?php

namespace ByTIC\Models\SmartProperties\Tests\RecordsTraits\HasTypes;

use ByTIC\Models\SmartProperties\Tests\AbstractTest;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\Records;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\Types\Custom\Tournament;

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

    public function testGetStatuses()
    {
        $types = $this->object->getTypes();
        self::assertCount(3, $types);
        self::assertEquals(['custom-tournament', 'individual', 'relay'], array_keys($types));
        self::assertInstanceOf(Tournament::class, $this->object->getType('tournament'));
    }


    protected function setUp(): void
    {
        parent::setUp();
        $this->object = new Records();
    }
}
