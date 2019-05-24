<?php

namespace Riddlestone\Clockwork\Calendars\Test\Model;

use DateTime;
use PHPUnit\Framework\TestCase;
use Riddlestone\Clockwork\Calendars\Model\EventInterface;
use Riddlestone\Clockwork\Calendars\Model\Month;

/**
 * Class MonthTest
 * @package Riddlestone\Clockwork\Calendars\Test
 */
class MonthTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testConstructor()
    {
        $month = new Month(2019, 5);
        $this->assertEquals(\DateTime::createFromFormat('Y-m-d H:i:s', '2019-04-29 00:00:00'), $month->getFrom());
        $this->assertEquals(\DateTime::createFromFormat('Y-m-d H:i:s', '2019-06-02 23:59:59'), $month->getTo());
        $this->assertCount(35, $month->getDates());

        $month = new Month(2019, 5, 3);
        $this->assertEquals(\DateTime::createFromFormat('Y-m-d H:i:s', '2019-05-01 00:00:00'), $month->getFrom());
        $this->assertEquals(\DateTime::createFromFormat('Y-m-d H:i:s', '2019-06-04 23:59:59'), $month->getTo());

        $month = new Month(2019, 5, 7);
        $this->assertEquals(\DateTime::createFromFormat('Y-m-d H:i:s', '2019-04-28 00:00:00'), $month->getFrom());
        $this->assertEquals(\DateTime::createFromFormat('Y-m-d H:i:s', '2019-06-01 23:59:59'), $month->getTo());

        $month = new Month(2019, 9);
        $this->assertEquals(\DateTime::createFromFormat('Y-m-d H:i:s', '2019-08-26 00:00:00'), $month->getFrom());
        $this->assertEquals(\DateTime::createFromFormat('Y-m-d H:i:s', '2019-10-06 23:59:59'), $month->getTo());
        $this->assertCount(42, $month->getDates());
    }

    /**
     * @throws \Exception
     */
    public function testGetEvents()
    {
        $month = new Month(2019, 5);
        $this->assertEmpty($month->getEvents());

        $event1 = $this->createMock(EventInterface::class);
        $event1->method('getStart')->willReturn(DateTime::createFromFormat('Y-m-d H:i:s', '2019-05-01 09:00:00'));
        $event1->method('getEnd')->willReturn(DateTime::createFromFormat('Y-m-d H:i:s', '2019-05-01 10:00:00'));
        $month->addEvent($event1);

        $event2 = $this->createMock(EventInterface::class);
        $event2->method('getStart')->willReturn(DateTime::createFromFormat('Y-m-d H:i:s', '2019-05-02 09:00:00'));
        $event2->method('getEnd')->willReturn(DateTime::createFromFormat('Y-m-d H:i:s', '2019-05-02 10:00:00'));
        $month->addEvent($event2);

        $event3 = $this->createMock(EventInterface::class);
        $event3->method('getStart')->willReturn(DateTime::createFromFormat('Y-m-d H:i:s', '2019-04-20 00:00:00'));
        $event3->method('getEnd')->willReturn(DateTime::createFromFormat('Y-m-d H:i:s', '2019-05-20 23:59:59'));
        $month->addEvent($event3);

        $this->assertEquals([$event3, $event1, $event2], $month->getEvents());
        $this->assertEquals([$event3, $event1], $month->getEvents(DateTime::createFromFormat('Y-m-d H:i:s', '2019-05-01 00:00:00')));
    }
}
