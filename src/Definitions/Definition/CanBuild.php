<?php

namespace ByTIC\Models\SmartProperties\Definitions\Definition;

/**
 * Trait CanBuild
 * @package ByTIC\Models\SmartProperties\Definitions\Traits
 */
trait CanBuild
{
    protected $build = false;

    protected function checkBuild()
    {
        if ($this->isBuild()) {
           return;
        }
        $this->build();
        $this->build = true;
    }

    /**
     * @return bool
     */
    public function isBuild(): bool
    {
        return $this->build === true;
    }

    /**
     * @param bool $build
     */
    public function setBuild(\Closure $build)
    {
        $this->build = $build;
    }

    protected function build()
    {
        if ($this->build instanceof \Closure) {
            call_user_func($this->build);
        }
    }
}