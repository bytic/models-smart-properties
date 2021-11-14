<?php

namespace ByTIC\Models\SmartProperties\Definitions\Builders;

use ByTIC\Models\SmartProperties\Definitions\RepositoryDefinitions;

/**
 * Class RepositoryBuilder
 * @package ByTIC\Models\SmartProperties\Definitions\Builders
 */
class RepositoryBuilder
{

    public static function for($manager, \Closure $builder): RepositoryDefinitions
    {
        $collection = new RepositoryDefinitions();
        $collection->setRepositoryName($manager);
        $collection->setBuilder($builder);
        return $collection;
    }
}