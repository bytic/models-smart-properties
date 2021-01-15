<?php

namespace ByTIC\Models\SmartProperties\Tests\Properties\AbstractProperty;

use ByTIC\Models\SmartProperties\Tests\AbstractTest;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\Types\Relay;

/**
 * Class GenericTest
 * @package ByTIC\Models\SmartProperties\Tests\Properties\AbstractProperty
 */
class GenericTest extends AbstractTest
{
    public function test_toString()
    {
        $type = new Relay();

        self::assertSame('relay', (string)$type);
        self::assertSame('N: relay', 'N: ' . $type);
    }

    public function test_compare_different_objects()
    {
        $object1 = new \stdClass();
        $object1->id = 1;
        $type1 = new Relay();
        $type1->setItem($object1);

        $object2 = new \stdClass();
        $object1->id = 2;
        $type2 = new Relay();
        $type2->setItem($object2);

        self::assertTrue((string) $type2 == (string) $type1);
    }
}
