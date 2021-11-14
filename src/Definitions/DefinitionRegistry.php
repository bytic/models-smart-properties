<?php

namespace ByTIC\Models\SmartProperties\Definitions;

use ByTIC\Models\SmartProperties\Definitions\Builders\RepositoryBuilder;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class DefinitionRegistry
 * @package ByTIC\Models\SmartProperties\Definitions
 */
class DefinitionRegistry
{
    use SingletonTrait;

    /**
     * @var RepositoryDefinitions[]
     */
    protected array $definitions = [];

    /**
     * @param $manager
     * @param \Closure|null $builder
     * @return RepositoryDefinitions
     */
    public function get($manager, \Closure $builder = null)
    {
        $managerName = $this->managerName($manager);
        if (!isset($this->definitions[$managerName])) {
            $this->definitions[$managerName] = RepositoryBuilder::for($manager, $builder);
        }
        return $this->definitions[$managerName];
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
}
