<?php

namespace ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasSmartProperties\RegistrationStatuses;

/**
 * Class AbstractStatus
 * @package KM42\Register\Models\Events\Pacers\RegistrationStatuses
 */
abstract class AbstractStatus extends \ByTIC\Models\SmartProperties\Properties\Statuses\Generic
{
    /**
     * @return string
     */
    public function getColor()
    {
        return '#999';
    }
}
