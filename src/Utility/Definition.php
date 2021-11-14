<?php

namespace ByTIC\Models\SmartProperties\Utility;

/**
 * Class Definition
 * @package ByTIC\Models\SmartProperties\Utility
 */
class Definition
{
    /**
     * @param $definition
     * @return mixed|string|null
     */
    public static function name($definition)
    {
        if ($definition instanceof \ByTIC\Models\SmartProperties\Definitions\Definition) {
            return $definition->getName();
        }
        return (string)$definition;
    }

    public static function findForManager()
    {

    }
}
