<?php

namespace ByTIC\Models\SmartProperties\Tests\RecordsTraits\HasSmartProperties;

use ByTIC\EventDispatcher\Dispatcher\EventDispatcher;
use ByTIC\Models\SmartProperties\Properties\AbstractProperty\Generic;
use ByTIC\Models\SmartProperties\Tests\AbstractTest;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasSmartProperties\Record;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasSmartProperties\Records;
use ByTIC\Models\SmartProperties\Tests\Fixtures\RecordsTraits\HasSmartProperties\RegistrationStatuses\Unregistered;
use Nip\Container\Container;
use Symfony\Component\Workflow\Event\Event;

/**
 * Class TraitsTest
 * @package ByTIC\Common\Tests\Payments\Methods
 */
class RecordTraitTest extends AbstractTest
{
    /**
     * @var Record
     */
    private $object;

    public function testGetPropertyWithoutValue()
    {
        $status = $this->object->getSmartProperty('Status');
        self::assertInstanceOf(Generic::class, $status);
        self::assertSame('allocated', $status->getName());

        $registrationStatus = $this->object->getSmartProperty('RegistrationStatus');
        self::assertInstanceOf(Generic::class, $registrationStatus);
        self::assertSame('unregistered', $registrationStatus->getName());
    }

    public function test_getProperty_EmptyValue()
    {
        $this->object->registration_status = '';
        $registrationStatus = $this->object->getSmartProperty('RegistrationStatus');
        self::assertInstanceOf(Unregistered::class, $registrationStatus);
    }

    public function testGetStatusWithValue()
    {
        $this->object->status = 'applicant';
        $this->object->registration_status = 'unpaid';

        $status = $this->object->getSmartProperty('Status');
        self::assertInstanceOf(Generic::class, $status);
        self::assertSame('applicant', $status->getName());

        $registrationStatus = $this->object->getSmartProperty('RegistrationStatus');
        self::assertInstanceOf(Generic::class, $registrationStatus);
        self::assertSame('unpaid', $registrationStatus->getName());
    }

    public function test_updateSmartProperty()
    {
        $this->object->setAttribute('status', 'applicant');

        $eventDispatcher = \Mockery::mock(EventDispatcher::class)->makePartial();
        $eventDispatcher->shouldReceive('dispatch')->once()->with(\Mockery::on(function ($event) {
            if (!($event instanceof Event)) {
                return false;
            }
            $transition = $event->getTransition();

            self::assertSame(['applicant'], $transition->getFroms());
            self::assertSame(['allocated'], $transition->getTos());
            return true;
        }));
        Container::getInstance()->set('events', $eventDispatcher);

        self::assertSame('applicant', $this->object->getSmartProperty('Status')->getName());

        $this->object->updateSmartProperty('Status', 'allocated');
        self::assertSame('allocated', $this->object->status);
        self::assertSame('allocated', $this->object->getSmartProperty('Status')->getName());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->object = new Record();

        $manager = new Records();
        $this->object->setManager($manager);
    }
}
