<?php

namespace ByTIC\Models\SmartProperties\Tests\Definitions\Traits;

use ByTIC\Models\SmartProperties\Tests\Definitions\AbstractDefinitionTest;

/**
 * Class HasPropertiesNamespacesTest
 * @package ByTIC\Models\SmartProperties\Tests\Definitions\Traits
 */
class HasPropertiesNamespacesTest extends AbstractDefinitionTest
{
    public function test_getPropertiesNamespaces()
    {
        $definition = $this->newDefinitionWithManager();
        $definition->getManager()->shouldReceive('getPropertiesNamespaces')->andReturn(['test']);
        $this->assertEquals(
            [
                'ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasTypes\\'
                => PROJECT_BASE_PATH
                    . DIRECTORY_SEPARATOR
                    . implode(DIRECTORY_SEPARATOR, ['vendor', 'mockery','mockery', 'library', 'Mockery', 'Loader'])
                    . DIRECTORY_SEPARATOR
            ],
            $definition->getPropertiesNamespaces()
        );
    }
}
