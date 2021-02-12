<?php

namespace ByTIC\Models\SmartProperties\Properties;

use ByTIC\Models\SmartProperties\Definitions\Definition;

/**
 * Class Registry
 * @package ByTIC\Models\SmartProperties\Properties
 */
class PropertiesRegistry
{
    protected static $registry = [];

    public static function set($subject, $property, $value)
    {
        $subjectName = static::subjectName($subject);
        $propertyName = static::propertyName($property);
        self::$registry[$subjectName][$propertyName] = $value;
    }

    /**
     * @param $subject
     * @param $property
     * @return mixed|null
     */
    public static function get($subject, $property)
    {
        $subjectName = static::subjectName($subject);
        $propertyName = static::propertyName($property);

        if (!isset(self::$registry[$subjectName][$propertyName])) {
            return null;
        }
        $value = self::$registry[$subjectName][$propertyName];
        if ($value instanceof \Closure) {
            self::$registry[$subjectName][$propertyName] = $value();
        }
        return self::$registry[$subjectName][$propertyName];
    }

    /**
     * @param $subject
     * @param $property
     * @param $init
     */
    public static function getWithInit($subject, $property, $init)
    {
        $return = static::get($subject, $property);
        if ($return) {
            return $return;
        }
        if ($init instanceof \Closure) {
            $init = $init();
        }

        $subjectName = static::subjectName($subject);
        $propertyName = static::propertyName($property);
        self::$registry[$subjectName][$propertyName] = $init;
        return $init;
    }

    /**
     * @param $property
     * @return string
     */
    protected static function propertyName($property): string
    {
        if ($property instanceof Definition) {
            return $property->getName();
        }
        return (string)$property;
    }

    /**
     * @param $subject
     * @return string
     */
    protected static function subjectName($subject): string
    {
        $propertyMemory = 'splObjectUnique';
        if (isset($subject->{$propertyMemory})) {
            return $subject->{$propertyMemory};
        }
        $id = uniqid();
        $subject->{$propertyMemory} = $id;
        return $id;
    }
}
