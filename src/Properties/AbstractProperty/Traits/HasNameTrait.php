<?php

namespace ByTIC\Models\SmartProperties\Properties\AbstractProperty\Traits;

use ReflectionClass;

/**
 * Trait HasNameTrait
 * @package ByTIC\Models\SmartProperties\Properties\AbstractProperty\Traits
 */
trait HasNameTrait
{
    protected $name = null;

    protected $aliases = [];

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        if ($this->name == null) {
            $this->initName();
        }

        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    protected function initName()
    {
        $this->setName($this->generateName());
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
        try {
            return (new ReflectionClass($this))->getShortName();
        } catch (\ReflectionException $e) {
            return '';
        }
    }
}
