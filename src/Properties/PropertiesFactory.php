<?php

namespace ByTIC\Models\SmartProperties\Properties;

use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic as Property;

/**
 * Class PropertiesFactory
 * @package ByTIC\Models\SmartProperties\Properties
 */
class PropertiesFactory
{
    public static function forDefinition($definition, $className, $baseNamespace)
    {
        $object = new $className();
        /** @var Property $object */
        $object->setManager($definition->getManager());
        $object->setField($definition->getField());
        $object->setNamespace($baseNamespace);
        return $object;
    }
}
