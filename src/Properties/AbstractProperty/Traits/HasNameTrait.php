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

    /**
     * @return string
     */
    public function getName()
    {
        if ($this->name == null) {
            $this->initName();
        }

        return $this->name;
    }

    public function initName()
    {
        $this->name = $this->generateName();
    }

    /**
     * @return string
     */
    public function generateName()
    {
        $name = $this->generateNameFromClass();
        $name = inflector()->unclassify($name);

        return $name;
    }

    /**
     * @return string
     */
    protected function generateNameFromClass()
    {
        try {
            return (new ReflectionClass($this))->getShortName();
        } catch (\ReflectionException $e) {
        }
    }
}
