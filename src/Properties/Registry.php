<?php

namespace ByTIC\Models\SmartProperties\Properties;

use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic;

/**
 * Class Registry
 * @package ByTIC\Models\SmartProperties\Properties
 */
class Registry
{
    protected static $registry = [];

    public static function set(Generic $property, $item)
    {
        $key = microtime() . '-' . spl_object_hash($item);
        self::$registry[get_class($property)][$key] = $item;
        return $key;
    }

    public static function get($property, $key)
    {
        $class = get_class($property);
        if (isset(self::$registry[$class][$key])) {
            return self::$registry[$class][$key];
        }
        return null;
    }
}