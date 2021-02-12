<?php

namespace ByTIC\Models\SmartProperties\Tests\Definitions\Traits;

use ByTIC\Models\SmartProperties\Definitions\Definition;
use ByTIC\Models\SmartProperties\Tests\AbstractTest;

/**
 * Class HasPlacesTest
 * @package ByTIC\Models\SmartProperties\Tests\Definitions\Traits
 */
class HasPlacesTest extends AbstractTest
{
    public function test_getPlaces()
    {
        $definition = new Definition();

        $places = ['pending', 'active'];
        $definition->setPlaces($places);
        self::assertSame($places, $definition->getPlaces());
    }
}