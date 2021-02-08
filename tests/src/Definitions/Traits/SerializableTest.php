<?php

namespace ByTIC\Models\SmartProperties\Tests\Definitions\Traits;

use ByTIC\Models\SmartProperties\Properties\Definitions\Definition;
use ByTIC\Models\SmartProperties\Tests\AbstractTest;

/**
 * Class SerializableTest
 * @package ByTIC\Models\SmartProperties\Tests\Definitions\Traits
 */
class SerializableTest extends AbstractTest
{
    public function test_serialize()
    {
        $definition = new Definition();
        $definition->setField('status');
        $definition->setPlaces(['pending', 'published']);
        $data = serialize($definition);

        self::assertSame('', $data);
        $definition2 = unserialize($data);
        self::assertSame($definition, $definition2);
    }

}
