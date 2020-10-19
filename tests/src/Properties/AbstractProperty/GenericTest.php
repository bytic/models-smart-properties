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
}