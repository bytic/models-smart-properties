<?php

namespace ByTIC\Models\SmartProperties\Tests\Properties\Definitions;

use ByTIC\Models\SmartProperties\Properties\Definitions\Definition;
use ByTIC\Models\SmartProperties\Tests\AbstractTest;

/**
 * Class DefinitionTest
 * @package ByTIC\Models\SmartProperties\Tests\Properties\Definitions
 */
class DefinitionTest extends AbstractTest
{
    public function test_getItemsNames_from_files()
    {
        $definition = new Definition();
        $definition->setItemsDirectory(TEST_FIXTURE_PATH . '/RecordsTraits/HasTypes/Types');

        $names = $definition->getItemsNames();
        self::assertIsArray($names);
        self::assertCount(5, $names);
    }
}
