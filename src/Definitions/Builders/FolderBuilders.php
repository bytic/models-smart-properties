<?php

namespace ByTIC\Models\SmartProperties\Definitions\Builders;

use ByTIC\Models\SmartProperties\Definitions\Definition;
use Nip\Records\AbstractModels\RecordManager;
use Nip\Utility\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Class FolderBuilders
 * @package ByTIC\Models\SmartProperties\Definitions\Builders
 */
class FolderBuilders
{
    /**
     * @var RecordManager
     */
    protected $manager;

    /**
     * @var Definition
     */
    protected $definition;

    protected $itemsDirectory = null;

    /**
     * @param RecordManager $manager
     * @param string $field
     * @param null|string $name
     */
    public static function create($manager, $field, $name = null): Definition
    {
        $builder = new static();
        $builder->manager = $manager;
        $builder->definition = $builder->newDefinition($manager);
        $builder->definition->setField($field);
        if ($name) {
            $builder->definition->setName($name);
        }
        $builder->definition->setPlaces($builder->buildPlaces());
        return $builder->definition;
    }


    /**
     * @param $manager
     * @return Definition
     */
    protected function newDefinition($manager): Definition
    {
        $definition = new Definition();
        $definition->setManager($manager);

        return $definition;
    }

    /**
     * @return array
     */
    protected function buildPlaces()
    {
        $names = $this->getItemsNamesFromManager();

        $names = $names ?: $this->getItemsNamesFromFiles();

        foreach ($names as $key => $name) {
            if ($this->isAbstractItemName($name)) {
                unset($names[$key]);
            }
        }
        return $names;
    }


    /**
     * @return array
     */
    protected function getItemsNamesFromFiles(): array
    {
        $directory = $this->getItemsDirectory();
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        $names = [];
        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }
            $name = str_replace($directory, '', $file->getPathname());
            $name = str_replace('.php', '', $name);
            $names[] = trim($name, DIRECTORY_SEPARATOR . '\\');
        }

        return array_unique($names);
    }

    /**
     * @return array|boolean
     */
    protected function getItemsNamesFromManager()
    {
        $methodName = 'get' . $this->definition->getName() . 'Names';
        if (method_exists($this->manager, $methodName)) {
            return $this->manager->$methodName();
        }

        return false;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    protected function isAbstractItemName(string $name): bool
    {
        if (in_array($name, ['Abstract', 'Generic'])) {
            return true;
        }
        if (strpos($name, 'Abstract') === 0) {
            return true;
        }
        if (Str::endsWith($name, 'Trait')) {
            return true;
        }
        if (strpos($name, '\Abstract') !== false) {
            return true;
        }
        if (strpos($name, DIRECTORY_SEPARATOR . 'Abstract') !== false) {
            return true;
        }

        return false;
    }

    /**
     * @return null|string
     */
    protected function getItemsDirectory()
    {
        if ($this->itemsDirectory == null) {
            $this->initItemsDirectory();
        }

        return $this->itemsDirectory;
    }

    /**
     * @param $dir
     */
    protected function setItemsDirectory($dir)
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
        $methodName = 'get' . $this->definition->getName() . 'ItemsDirectory';
        if (method_exists($this->manager, $methodName)) {
            return $this->manager->$methodName();
        }

        $methodName = 'get' . Str::plural($this->definition->getName()) . 'Directory';
        if (method_exists($this->manager, $methodName)) {
            return $this->manager->$methodName();
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
        return $this->definition->getLabel();
    }
}
