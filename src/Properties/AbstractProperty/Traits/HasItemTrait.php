<?php

namespace ByTIC\Models\SmartProperties\Properties\AbstractProperty\Traits;

use ByTIC\Models\SmartProperties\Properties\Registry;
use ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties\RecordTrait;
use Nip\Records\Record as Record;

/**
 * Trait HasItemTrait
 * @package ByTIC\Models\SmartProperties\Properties\AbstractProperty\Traits
 */
trait HasItemTrait
{
    /**
     * @var null|Record|RecordTrait
     */
    protected $item;

    /**
     * @return Record|null|RecordTrait
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param $i
     * @return $this
     */
    public function setItem($i)
    {
        $this->item = $i;

        return $this;
    }
}
