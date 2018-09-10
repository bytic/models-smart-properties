<?php

namespace ByTIC\Records\SmartProperties\RecordsTraits\AbstractTrait;

use Nip\Records\AbstractModels\RecordManager;
use Nip_Registry;

/**
 * Class RecordTrait
 * @package ByTIC\Records\SmartProperties\RecordsTraits\AbstractTrait
 *
 * @property int $id
 *
 */
trait RecordTrait
{

    /**
     * @return RecordManager
     */
    abstract public function getManager();

    /**
     * @param RecordManager|RecordsTrait $manager
     * @return $this
     */
    abstract public function setManager($manager);

    /**
     * @return Nip_Registry
     */
    abstract public function getRegistry();

    /**
     * @return mixed
     */
    abstract public function update();

    /**
     * @param $data
     * @return mixed
     */
    abstract public function writeData($data = false);

    /**
     * @return array
     */
    abstract public function toArray();

    abstract public function save();

    /**
     * @return boolean
     */
    abstract public function exists();
}
