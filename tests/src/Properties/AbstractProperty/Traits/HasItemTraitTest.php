<?php

namespace ByTIC\Models\SmartProperties\Tests\Properties\AbstractProperty\Traits;

use ByTIC\Models\SmartProperties\Tests\AbstractTest;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\Types\Relay;

/**
 * Class HasItemTraitTest
 * @package ByTIC\Models\SmartProperties\Tests\Properties\AbstractProperty\Traits
 */
class HasItemTraitTest extends AbstractTest
{

    public function test_compare_different_objects()
    {
        $object = new \stdClass();
        $object->id = 1;
        $type = new Relay();
        $type->setItem($object);

        self::assertSame($object, $type->getItem());
    }
}
