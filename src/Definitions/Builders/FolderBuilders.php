<?php

namespace ByTIC\Models\SmartProperties\Definitions\Builders;

use ByTIC\Models\SmartProperties\Definitions\Definition;
use ByTIC\Models\SmartProperties\Properties\PropertiesFactory;
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
        $builder->definition->setBuild(function () use ($builder) {
            $items = $builder->buildItems();
            foreach ($items as $item) {
                $builder->definition->addItem($item);
            }
        });
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
    protected function buildItems()
    {
        $items = $this->getItemsFromFiles();

        $names = $this->getItemsNamesFromManager();
        if (!is_array($names)) {
            return $items;
        }
        $return = [];
        foreach ($names as $name) {
            if (isset($items[$name])) {
                $return[$name] = $items[$name];
                unset($items[$name]);
            }
        }

        return array_merge($return, $items);
    }


    /**
     * @return array
     */
    protected function getItemsFromFiles(): array
    {
        $directories = $this->definition->getPropertiesNamespaces();
        $items = [];
        foreach ($directories as $namespace => $directory) {
            $items = array_merge($items, $this->getItemsFromDirectory($directory, $namespace));
        }
        return $items;
    }

    protected function getItemsFromDirectory($directory, $namespace): array
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        $names = [];
        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }
            $name = str_replace($directory, '', $file->getPathname());
            $name = str_replace('.php', '', $name);
            $name = trim($name, DIRECTORY_SEPARATOR . '\\');
            if ($this->isAbstractItemName($name)) {
                continue;
            }
            $class = str_replace('/', '\\', $namespace . '' . $name);
            if (class_exists($class)) {
                $names[$name] = PropertiesFactory::forDefinition($this->definition, $class, $namespace);
            }
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


}
