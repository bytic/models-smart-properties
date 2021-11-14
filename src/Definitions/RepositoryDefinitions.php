<?php

namespace ByTIC\Models\SmartProperties\Definitions;

use ByTIC\Models\SmartProperties\Exceptions\InvalidArgumentException;
use Nip\Collections\Lazy\AbstractLazyCollection;

/**
 * Class RepositoryDefinitions
 * @package ByTIC\Models\SmartProperties\Definitions
 */
class RepositoryDefinitions extends AbstractLazyCollection
{
    protected $repositoryName;

    /**
     * @var \Closure
     */
    protected $builder;

    /**
     * @param mixed $repositoryName
     */
    public function setRepositoryName($repositoryName): void
    {
        $this->repositoryName = $repositoryName;
    }

    /**
     * @param \Closure $builder
     */
    public function setBuilder(\Closure $builder): void
    {
        $this->builder = $builder;
    }

    public function get($key, $default = null)
    {
        $definition = parent::get($key, $default);
        if ($definition instanceof Definition) {
            return $definition;
        }
        throw new InvalidArgumentException(sprintf(
            'Unable to find a definition "%s" for class "%s".',
            $key, $this->repositoryName
        ));
    }

    /**
     * @param $definition
     * @return bool
     */
    public function offsetExists($key)
    {
        $key = \ByTIC\Models\SmartProperties\Utility\Definition::name($key);
        return parent::offsetExists($key);
    }

    /**
     * @param $manager
     * @param string|Definition $definition
     * @return mixed
     */
    public function offsetGet($key)
    {
        $key = \ByTIC\Models\SmartProperties\Utility\Definition::name($key);

        if ($this->has($key)) {
            return parent::offsetGet($key);
        }

        throw new InvalidArgumentException(sprintf(
            'Unable to find a definition "%s" for class "%s".',
            $key, $this->repositoryName
        ));
    }

    public function offsetSet($key, $value)
    {
        $key = $key ?? \ByTIC\Models\SmartProperties\Utility\Definition::name($value);
        parent::offsetSet($key, $value);
    }

    protected function doLoad(): void
    {
        call_user_func($this->builder);
    }
}
