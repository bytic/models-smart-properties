<?php

namespace ByTIC\Models\SmartProperties\Tests\RecordsTraits\HasSmartProperties;

use ByTIC\Models\SmartProperties\Properties\Definitions\Definition;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasSmartProperties\Records;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasSmartProperties\RegistrationStatuses\FreeConfirmed;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasSmartProperties\RegistrationStatuses\Unpaid;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasSmartProperties\Statuses\Allocated;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasSmartProperties\Statuses\Applicant;
use ByTIC\Models\SmartProperties\Tests\AbstractTest;

/**
 * Class TraitsTest
 * @package ByTIC\Common\Tests\Payments\Methods
 */
class RecordsTraitTest extends AbstractTest
{
    /**
     * @var Records
     */
    private $object;

    public function testGetSmartPropertiesDefinitions()
    {
        $definitions = $this->object->getSmartPropertiesDefinitions();
        self::assertCount(2, $definitions);
    }

    public function testGetSmartPropertyDefinition()
    {
        /** @var Definition $statusDefinition */
        $statusDefinition = $this->object->getSmartPropertyDefinition('Status');
        self::assertInstanceOf(Definition::class, $statusDefinition);
        self::assertSame('Status', $statusDefinition->getName());
        self::assertSame('status', $statusDefinition->getField());
        self::assertSame('Statuses', $statusDefinition->getLabel());
        self::assertStringEndsWith(
            str_replace('/', DIRECTORY_SEPARATOR, 'RecordsTraits/HasSmartProperties/Statuses'),
            $statusDefinition->getItemsDirectory()
        );

        /** @var Definition $statusDefinition */
        $statusDefinition = $this->object->getSmartPropertyDefinition('RegistrationStatus');
        self::assertInstanceOf(Definition::class, $statusDefinition);
        self::assertSame('RegistrationStatus', $statusDefinition->getName());
        self::assertSame('registration_status', $statusDefinition->getField());
        self::assertSame('RegistrationStatuses', $statusDefinition->getLabel());
        self::assertStringEndsWith(
            str_replace('/', DIRECTORY_SEPARATOR, 'RecordsTraits/HasSmartProperties/RegistrationStatuses'),
            $statusDefinition->getItemsDirectory()
        );
    }

    public function testGetSmartPropertyItems()
    {
        $statuses = $this->object->getSmartPropertyItems('Status');
        self::assertCount(2, $statuses);
        self::assertInstanceOf(Allocated::class, $statuses['allocated']);
        self::assertInstanceOf(Applicant::class, $statuses['applicant']);

        $statuses = $this->object->getSmartPropertyItems('RegistrationStatus');
        self::assertCount(4, $statuses);
        self::assertInstanceOf(FreeConfirmed::class, $statuses['free_confirmed']);
        self::assertInstanceOf(Unpaid::class, $statuses['unpaid']);
    }

    public function testGetSmartPropertyValues()
    {
        $values = $this->object->getSmartPropertyValues('Status', 'name');
        self::assertSame(['allocated', 'applicant'], $values);

        $values = $this->object->getSmartPropertyValues('RegistrationStatus', 'name');
        self::assertEqualsCanonicalizing(['free_confirmed', 'paid_confirmed',  'unregistered', 'unpaid'], $values);
    }

    public function testGetSmartPropertyItem()
    {
        $status = $this->object->getSmartPropertyItem('Status', 'allocated');
        self::assertInstanceOf(Allocated::class, $status);
    }


    protected function setUp(): void
    {
        parent::setUp();
        $this->object = new Records();
    }
}
