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

        self::assertSame(
            'C:62:"ByTIC\Models\SmartProperties\Properties\Definitions\Definition":115:{a:4:{s:4:"name";N;s:5:"field";s:6:"status";s:5:"label";N;s:6:"places";a:2:{i:0;s:7:"pending";i:1;s:9:"published";}}}',
            $data
        );
        $definition2 = unserialize($data);
        self::assertEquals($definition, $definition2);
    }

}
