<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasTypes;

use ByTIC\Models\SmartProperties\Properties\Types\Generic as GenericType;

/**
 * Class RecordTrait
 *
 * @property $type
 *
 * @method RecordsTrait getManager
 *
 * @package ByTIC\Models\SmartProperties\RecordsTraits\HasTypes
 */
trait RecordTrait
{
    use \ByTIC\Models\SmartProperties\RecordsTraits\AbstractTrait\RecordTrait;

    /**
     * @var GenericType
     */
    protected $typeObject = null;

    /**
     * @return GenericType
     */
    public function getType()
    {
        if ($this->typeObject === null) {
            $this->initType();
        }

        return $this->typeObject;
    }

    public function initType()
    {
        $this->typeObject = $this->getNewType($this->getTypeValue());
    }

    /**
     * @param $type
     * @return mixed
     * @throws \Nip\Logger\Exception
     */
    public function getNewType($type)
    {
        $object = clone $this->getManager()->getType($type);
        $object->setItem($this);

        return $object;
    }

    /**
     * @return string
     */
    public function getTypeValue()
    {
        return $this->type;
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
     * @param GenericType $type
     * @return bool|GenericType|RecordTrait
     * @throws \Nip\Logger\Exception
     */
    public function setType($type = null)
    {
        if ($type instanceof GenericType) {
            return $this->setTypeFromObject($type);
        }
        $this->setDataValue('type', $type);
        if (is_object($this->typeObject) && $this->typeObject->getName() === $type) {
            return $this->typeObject;
        }
        $this->typeObject = $this->getNewType($type);

        return $this->typeObject;
    }

    /**
     * @param $typeObject
     * @return RecordTrait
     */
    public function setTypeFromObject($typeObject)
    {
        $this->typeObject = $typeObject;
        $this->setDataValue('type', $typeObject->getName());
        return $typeObject;
    }
}
