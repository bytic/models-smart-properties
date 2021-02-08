<?php

namespace ByTIC\Models\SmartProperties\RecordsTraits\HasSmartProperties;

use ByTIC\Models\SmartProperties\Definitions\Builders\FolderBuilders;
use ByTIC\Models\SmartProperties\Definitions\DefinitionRegistry;
use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic as PropertyValue;
use ByTIC\Models\SmartProperties\Properties\Definitions\Definition;
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
    public function getSmartPropertiesDefinitions()
    {
        $this->checkSmartPropertiesDefinitions();

        return $this->getSmartPropertyDefinitionRegistry()->getAll($this);
    }

    /**
     * @param $name
     * @return PropertyValue[]|null
     * @throws Exception
     */
    public function getSmartPropertyItems($name)
    {
        $definition = $this->getSmartPropertyDefinition($name);
        if ($definition) {
            return $definition->getItems();
        }
        throw new Exception('invalid smart property [' . $name . ']');
    }

    /**
     * @param string $name
     * @return null|Definition
     */
    public function getSmartPropertyDefinition($name)
    {
        if (!$this->hasSmartPropertyDefinition($name)) {
            return null;
        }

        return $this->getSmartPropertyDefinitionRegistry()->get($this, $name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasSmartPropertyDefinition($name)
    {
        $this->checkSmartPropertiesDefinitions();

        return $this->getSmartPropertyDefinitionRegistry()->has($this, $name);
    }

    /**
     * @param $name
     * @param $field
     * @return \ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic[]|null
     * @throws Exception
     */
    public function getSmartPropertyValues($name, $field)
    {
        $definition = $this->getSmartPropertyDefinition($name);
        if ($definition) {
            return $definition->getValues($field);
        }
        throw new Exception('invalid smart property [' . $name . ']');
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
        if ($definition) {
            return $definition->getItem($value);
        }
        throw new Exception('invalid smart property [' . $property . ']');
    }

    protected function checkSmartPropertiesDefinitions()
    {
        $this->getSmartPropertyDefinitionRegistry()->checkDefinitionToBuild($this, function () {
            $this->registerSmartProperties();
        });
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
        $this->getSmartPropertyDefinitionRegistry()->set($this, $definition);
    }

    /**
     * @return DefinitionRegistry
     */
    protected function getSmartPropertyDefinitionRegistry(): DefinitionRegistry
    {
        return DefinitionRegistry::instance();
    }
}
