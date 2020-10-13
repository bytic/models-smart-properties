<?php

namespace ByTIC\Models\SmartProperties\Properties\Definitions\Traits;

use Nip\Utility\Str;

/**
 * Trait HasItemsDirectoryTrait
 * @package ByTIC\Models\SmartProperties\Properties\Definitions\Traits
 */
trait HasItemsDirectoryTrait
{
    protected $itemsDirectory = null;


    /**
     * @return null|string
     */
    public function getItemsDirectory()
    {
        if ($this->itemsDirectory == null) {
            $this->initItemsDirectory();
        }

        return $this->itemsDirectory;
    }

    /**
     * @param $dir
     */
    public function setItemsDirectory($dir)
    {
        $this->itemsDirectory = $dir;
    }

    protected function initItemsDirectory()
    {
        $this->setItemsDirectory($this->generateItemsDirectory());
    }

    /**
     * @return string
     */
    protected function generateItemsDirectory()
    {
        $methodName = 'get' . $this->getName() . 'ItemsDirectory';
        if (method_exists($this->getManager(), $methodName)) {
            return $this->getManager()->$methodName();
        }

        $methodName = 'get' . Str::plural($this->getName()) . 'Directory';
        if (method_exists($this->getManager(), $methodName)) {
            return $this->getManager()->$methodName();
        }

        return $this->generateManagerDirectory() . DIRECTORY_SEPARATOR . $this->generatePropertyDirectory();
    }

    /**
     * @return string
     */
    protected function generateManagerDirectory()
    {
        $reflector = new \ReflectionObject($this->getManager());

        return dirname($reflector->getFileName());
    }

    /**
     * @return string
     */
    protected function generatePropertyDirectory()
    {
        return $this->getLabel();
    }
}
