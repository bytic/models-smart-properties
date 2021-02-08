<?php

namespace ByTIC\Models\SmartProperties\Definitions\Traits;

/**
 * Trait HasName
 * @package ByTIC\Models\SmartProperties\Definitions\Traits
 */
trait HasName
{

    /**
     * @var string
     */
    protected $name = null;


    /**
     * @return mixed
     */
    public function getName(): ?string
    {
        if ($this->name === null) {
            $this->initName();
        }

        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    protected function initName()
    {
        $name = inflector()->classify($this->getField());
        $this->setName($name);
    }

}