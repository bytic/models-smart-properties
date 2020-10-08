<?php

namespace ByTIC\Models\SmartProperties\Properties\Types;

use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic as GenericProperty;
use ReflectionClass;

/**
 * Class Generic
 * @package ByTIC\Common\Records\Types
 */
abstract class Generic extends GenericProperty
{
    /**
     * @return string
     */
    protected function getLabelSlug()
    {
        return 'types';
    }

    /**
     * @return string
     * @throws \ReflectionException
     */
    protected function generateNameFromClass()
    {
        if ($this->hasManager()) {
            $namespaceTypes = $this->getManager()->getTypeNamespace();
            $name = (new ReflectionClass($this))->getName();

            return str_replace($namespaceTypes, '', $name);
        }

        return parent::generateNameFromClass();
    }
}
