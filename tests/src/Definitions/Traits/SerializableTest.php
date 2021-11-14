<?php

namespace ByTIC\Models\SmartProperties\Tests\Definitions\Traits;

use ByTIC\Models\SmartProperties\Definitions\Definition;
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

        self::assertSame(
            file_get_contents(TEST_FIXTURE_PATH . '/serialized/definitions/simple.serialized'),
            $data
        );
        $definition2 = unserialize($data);
        self::assertEquals($definition, $definition2);
    }

}
