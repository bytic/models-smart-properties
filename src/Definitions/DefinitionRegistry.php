<?php

namespace ByTIC\Models\SmartProperties\Definitions;

use ByTIC\Models\SmartProperties\Exceptions\InvalidArgumentException;
use ByTIC\Models\SmartProperties\Properties\Definitions\Definition;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class DefinitionRegistry
 * @package ByTIC\Models\SmartProperties\Definitions
 */
class DefinitionRegistry
{
    use SingletonTrait;

    /**
     * @var Definition[]
     */
    protected $builders = [];

    /**
     * @var []
     */
    protected $definitionsBuilt = [];

    /**
     * @var Definition[]
     */
    protected $definitions = [];

    public function has($manager, string $definitionName): bool
    {
        $managerName = $this->managerName($manager);

        if (!isset($this->definitions[$managerName][$definitionName])) {
            return false;
        }

        return true;
    }

    /**
     * @param $manager
     * @param string $definitionName
     * @return mixed
     */
    public function get($manager, string $definitionName)
    {
        $managerName = $this->managerName($manager);

        if (!isset($this->definitions[$managerName][$definitionName])) {
            throw new InvalidArgumentException(sprintf(
                'Unable to find a definition "%s" for class "%s".',
                $definitionName, $managerName
            ));
        }

        return $this->definitions[$managerName][$definitionName];
    }

    /**
     * @param $manager
     * @return mixed
     */
    public function getAll($manager)
    {
        $managerName = $this->managerName($manager);

        if (!isset($this->definitions[$managerName])) {
            return [];
        }

        return $this->definitions[$managerName];
    }

    /**
     * @param object $manager
     * @param $definition
     */
    public function set(object $manager, $definition)
    {
        $managerName = $this->managerName($manager);
        $definitionName = $this->definitionName($definition);

        $this->definitions[$managerName][$definitionName] = $definition;
    }

    /**
     * @param object $manager
     * @param \Closure $callback
     */
    public function checkDefinitionToBuild(object $manager, \Closure $callback)
    {
        $managerName = $this->managerName($manager);
        if (isset($this->definitionsBuilt[$managerName])) {
            return;
        }
        $callback();
        $this->definitionsBuilt[$managerName] = true;
    }

    /**
     * @param object|string $manager
     * @return string
     */
    protected function managerName($manager): string
    {
        if (is_object($manager)) {
            return get_class($manager);
        }
        return (string)$manager;
    }

    /**
     * @param object|string $definition
     * @return string
     */
    protected function definitionName($definition): string
    {
        if ($definition instanceof Definition) {
            return $definition->getName();
        }
        return (string)$definition;
    }
}
