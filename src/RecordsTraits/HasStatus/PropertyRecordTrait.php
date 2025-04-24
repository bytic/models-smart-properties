<?php
declare(strict_types=1);

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasStatus;

use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic;

/**
 * Trait PropertyRecordTrait
 * @package ByTIC\Models\SmartProperties\RecordsTraits\HasStatus
 */
trait PropertyRecordTrait
{
    /**
     * @return Generic
     */
    public function getStatus()
    {
        return $this->getSmartProperty('Status');
    }

    /**
     * @return Generic|null
     */
    public function getStatusObject()
    {
        $status = $this->getPropertyRaw('status');
        $property = $this->getSmartProperty('Status');
        if ($status == $property->getName()) {
            return $property;
        }
        $this->setStatus($status);
        return $this->getSmartProperty('Status');
    }

    /**
     * @param $value
     */
    public function setStatus($value)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->setSmartProperty('Status', $value);
    }

    /**
     * @param $status
     * @return Generic
     */
    public function getNewStatus($status)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->getNewSmartPropertyFromValue('Status', $status);
    }

    /**
     * @param bool $status
     * @return bool|void
     */
    public function updateStatus($status = false)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->updateSmartProperty('Status', $status);
    }

    /**
     * @param $status
     * @return bool
     */
    public function isInStatus($status): bool
    {
        $status = is_array($status) ? $status : [$status];
        foreach ($status as $singleStatus) {
            if ($this->isInStatusSingle($singleStatus)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $status
     * @return bool
     */
    protected function isInStatusSingle($status): bool
    {
        $statusObject = $this->getStatusObject();
        if (class_exists($status)) {
            return ($statusObject instanceof $status);
        }

        return $statusObject->getName() == $status;
    }
}
