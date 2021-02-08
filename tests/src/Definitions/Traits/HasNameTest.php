<?php

namespace ByTIC\Models\SmartProperties\Tests\Definitions\Traits;

use ByTIC\Models\SmartProperties\Properties\Definitions\Definition;
use ByTIC\Models\SmartProperties\Tests\AbstractTest;

/**
 * Class HasNameTest
 * @package ByTIC\Models\SmartProperties\Tests\Definitions\Traits
 */
class HasNameTest extends AbstractTest
{
    /**
     * @param $field
     * @param $name
     * @dataProvider date_infer_name_from_field
     */
    public function test_infer_name_from_field($field, $name)
    {
        $definition = new Definition();
        $definition->setField($field);
        self::assertSame($name, $definition->getName());
    }

    public function date_infer_name_from_field(): array
    {
        return [
            ['status','Status'],
        ];
    }
}
