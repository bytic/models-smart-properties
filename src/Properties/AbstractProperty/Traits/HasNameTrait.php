<?php

namespace ByTIC\Models\SmartProperties\Properties\AbstractProperty\Traits;

use ReflectionClass;

/**
 * Trait HasNameTrait
 * @package ByTIC\Models\SmartProperties\Properties\AbstractProperty\Traits
 */
trait HasNameTrait
{
    protected $namespace = null;

    protected $aliases = [];

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return array_merge($this->aliases, [$this->generateNameFromClass()]);
    }

    /**
     * @return null
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param null $namespace
     */
    public function setNamespace($namespace): void
    {
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    protected function generateName(): string
    {
        $name = $this->generateNameFromClass();
        $name = inflector()->unclassify($name);

        return $name;
    }

    /**
     * @return string
     */
    protected function generateNameFromClass(): string
    {
        $class = static::class;
        $base = $this->getNamespace();
        if ($base && strpos($class, $base) ===0) {
            return str_replace($base, '', $class);
        }
        try {
            return (new ReflectionClass($this))->getShortName();
        } catch (\ReflectionException $e) {
            return '';
        }
    }
}
