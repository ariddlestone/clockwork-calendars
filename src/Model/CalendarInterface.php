<?php

namespace Riddlestone\Clockwork\Calendars\Model;

use DateTimeInterface;

/**
 * Interface CalendarInterface
 * @package Riddlestone\Clockwork\Calendars
 */
interface CalendarInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param DateTimeInterface $from
     * @param DateTimeInterface $to
     * @return EventInterface[]
     */
    public function getEvents(DateTimeInterface $from, DateTimeInterface $to): array;
}
