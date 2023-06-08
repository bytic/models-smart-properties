<?php

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

    public function getStatusObject()
    {
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

    public function isInStatus($status): bool
    {
        $statusObject = $this->getStatusObject();
        if (class_exists($status)) {
            return $statusObject instanceof $status;
        }

        return $status->getName() == $status;
    }
}
