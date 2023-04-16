<?php

namespace ByTIC\Models\SmartProperties\Definitions\Definition;

use Nip\Utility\Str;

/**
 * Trait HasPropertiesNamespaces
 * @package ByTIC\Models\SmartProperties\Definitions\Definition
 */
trait HasPropertiesNamespaces
{
    protected $propertiesNamespaces = null;

    /**
     * @return null
     */
    public function getPropertiesNamespaces()
    {
        if ($this->propertiesNamespaces === null) {
            $this->initPropertiesNamespaces();
        }

        return $this->propertiesNamespaces;
    }

    protected function initPropertiesNamespaces()
    {
        $this->propertiesNamespaces = $this->generatePropertiesNamespaces();
    }

    protected function generatePropertiesNamespaces()
    {
        $directories = (array)$this->generateItemsDirectory();
        $rootNamespace = $this->getPropertyItemsRootNamespace();

        $propertiesNamespaces = [];
        foreach ($directories as $namespace => $directory) {
            $namespace = Str::contains($namespace, '\\') ? $namespace : $rootNamespace;
            $namespace = trim($namespace, '\\');
            $propertiesNamespaces[$namespace . '\\'] = $directory;
        }
        return $propertiesNamespaces;
    }

    /**
     * @return string
     */
    protected function generateItemsDirectory()
    {
        $name = $this->getName();
        if ($name) {
            $methodName = 'get' . $name . 'ItemsDirectory';
            if (method_exists($this->manager, $methodName)) {
                return $this->manager->$methodName();
            }

            $methodName = 'get' . Str::plural($name) . 'Directory';
            if (method_exists($this->manager, $methodName)) {
                return $this->manager->$methodName();
            }
        }

        return $this->generateManagerDirectory() . DIRECTORY_SEPARATOR . $this->generatePropertyDirectory();
    }

    /**
     * @return string
     */
    protected function generateManagerDirectory()
    {
        $reflector = new \ReflectionObject($this->manager);

        return dirname($reflector->getFileName());
    }

    /**
     * @return string
     */
    protected function generatePropertyDirectory()
    {
        return $this->getLabel();
    }

    /**
     * @return string
     */
    protected function getPropertyItemsRootNamespace(): string
    {
        $manager = $this->getManager();
        $method = 'get' . $this->getName() . 'ItemsRootNamespace';
        if (method_exists($manager, $method)) {
            return $manager->{$method}();
        }

        $method = 'get' . $this->getName() . 'Namespace';
        if (method_exists($manager, $method)) {
            return $manager->{$method}();
        }

        return $manager->getModelNamespace() . $this->getLabel() . '\\';
    }
}
