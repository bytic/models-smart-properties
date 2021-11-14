<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties;

use ByTIC\Models\SmartProperties\Definitions\Builders\FolderBuilders;
use ByTIC\Models\SmartProperties\Definitions\DefinitionRegistry;
use ByTIC\Models\SmartProperties\Definitions\RepositoryDefinitions;
use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic as PropertyValue;
use ByTIC\Models\SmartProperties\Definitions\Definition;
use Exception;

/**
 * Class RecordsTrait
 * @package ByTIC\Models\SmartProperties\RecordsTraits\HasStatus
 */
trait RecordsTrait
{
    use \ByTIC\Models\SmartProperties\RecordsTraits\AbstractTrait\RecordsTrait;

    /**
     * @return array
     */
    public function getSmartPropertiesDefinitions(): array
    {
        return $this->getSmartPropertyDefinitionRegistry()->all();
    }

    /**
     * @param $name
     * @return PropertyValue[]|null
     * @throws Exception
     */
    public function getSmartPropertyItems($name)
    {
        $definition = $this->getSmartPropertyDefinition($name);
        return $definition->getItems();
    }

    /**
     * @param string $name
     * @return null|Definition
     */
    public function getSmartPropertyDefinition($name)
    {
        return $this->getSmartPropertyDefinitionRegistry()->get($name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasSmartPropertyDefinition($name): bool
    {
        return $this->getSmartPropertyDefinitionRegistry()->has($name);
    }

    /**
     * @param $name
     * @param $field
     * @return \ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic[]|null
     */
    public function getSmartPropertyValues($name, $field)
    {
        $definition = $this->getSmartPropertyDefinition($name);
        return $definition->getValues($field);
    }

    /**
     * @param string $property
     * @param string $value
     * @return PropertyValue
     * @throws Exception
     */
    public function getSmartPropertyItem($property, $value)
    {
        $definition = $this->getSmartPropertyDefinition($property);
        return $definition->getItem($value);
    }


    abstract protected function registerSmartProperties();

    /**
     * @param $field
     */
    protected function registerSmartProperty($field, $name = null)
    {
        $definition = FolderBuilders::create($this, $field, $name);
        $this->addSmartPropertyDefinition($definition);
    }


    /**
     * @param Definition $definition
     */
    protected function addSmartPropertyDefinition($definition)
    {
        $this->getSmartPropertyDefinitionRegistry()->add($definition);
    }

    /**
     * @return RepositoryDefinitions
     */
    protected function getSmartPropertyDefinitionRegistry(): RepositoryDefinitions
    {
        return DefinitionRegistry::instance()->get($this, function () {
            $this->registerSmartProperties();
        });
    }
}
