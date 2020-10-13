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
     * @var null|string
     */
    protected $field = 'type';

    /**
     * @return string
     */
    protected function getLabelSlug()
    {
        return 'types';
    }
}
