<?php

namespace ByTIC\Models\SmartProperties\Tests\Definitions;

use ByTIC\Models\SmartProperties\Definitions\Definition;
use ByTIC\Models\SmartProperties\Tests\AbstractTest;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\Records;

/**
 * Class AbstractDefinitionTest
 * @package ByTIC\Models\SmartProperties\Tests\Definitions
 */
abstract class AbstractDefinitionTestCase extends AbstractTest
{
    protected function newDefinitionWithManager(): Definition
    {
        $definition = $this->newDefinition();

        $manager = \Mockery::mock(Records::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $definition->setManager($manager);

        return $definition;
    }

    protected function newDefinition(): Definition
    {
        $definition = new Definition();
        return $definition;
    }
}
