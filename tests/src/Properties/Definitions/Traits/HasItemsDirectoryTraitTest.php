<?php

namespace ByTIC\Models\SmartProperties\Tests\Properties\Definitions\Traits;

use ByTIC\Models\SmartProperties\Properties\Definitions\Definition;
use ByTIC\Models\SmartProperties\Tests\AbstractTest;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\Records;

/**
 * Class HasItemsDirectoryTraitTest
 * @package ByTIC\Models\SmartProperties\Tests\Properties\Definitions\Traits
 */
class HasItemsDirectoryTraitTest extends AbstractTest
{
    public function test_getItemsDirectory()
    {
        $manager = \Mockery::mock(Records::class)->makePartial();
        $manager->shouldReceive('getTypesDirectory')->once()->andReturn('test');

        $definition = new Definition();
        $definition->setName('Type');
        $definition->setManager($manager);

        self::assertSame(
            'test',
            $definition->getItemsDirectory()
        );
    }
}
