<?php

namespace ByTIC\Models\SmartProperties\Workflow;

/**
 * Class State
 * @package ByTIC\Models\SmartProperties\Workflow
 */
class State
{
    protected $name = null;

    /**
     * @return string
     */
    public function getName(): string
    {
        if ($this->name == null) {
            $this->initName();
        }

        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    protected function initName()
    {
        $this->setName($this->generateName());
    }

    protected function generateName()
    {
        throw new \Exception("State has not name set");
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
    }
}
