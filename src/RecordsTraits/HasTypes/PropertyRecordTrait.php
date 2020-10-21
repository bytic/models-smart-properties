<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasTypes;

use ByTIC\Models\SmartProperties\Properties\Types\Generic as GenericType;

trait PropertyRecordTrait
{


    /**
     * @return \ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic|GenericType
     */
    public function getType()
    {
        return $this->getSmartProperty('Type');
    }

    /**
     * @param $status
     * @return \ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic|GenericType
     */
    public function getNewType($status)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->getNewSmartPropertyFromValue('Type', $status);
    }

    /**
     * @param GenericType $type
     * @return bool
     * @throws \Nip\Logger\Exception
     */
    public function updateType($type = null)
    {
        if ($this->setType($type)) {
            $this->update();
        }

        return false;
    }

    /**
     * @param $value
     */
    public function setType($value)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->setSmartProperty('Type', $value);
    }

    /**
     * @param $typeObject
     * @return RecordTrait
     */
    public function setTypeFromObject($typeObject)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->setSmartProperty('Type', $typeObject);
        return $typeObject;
    }
}