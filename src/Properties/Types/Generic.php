<?php

namespace ByTIC\Records\SmartProperties\Properties\Types;

use ByTIC\Records\SmartProperties\Properties\AbstractProperty\Generic as GenericProperty;

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
}
