<?php

namespace ByTIC\Models\SmartProperties\Tests\Properties\AbstractProperty\Traits;

use ByTIC\Models\SmartProperties\Tests\AbstractTest;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\Types\Custom\Tournament;

/**
 * Class HasNameTest
 * @package ByTIC\Models\SmartProperties\Tests\Properties\AbstractProperty\Traits
 */
class HasNameTest extends AbstractTest
{
    public function test_getName()
    {
        $property = new Tournament();
        $property->setNamespace('ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\Types\\');

        self::assertSame('custom-tournament', $property->getName());
    }
}
