<?php

namespace Riddlestone\Clockwork\Calendars\Model;

use DateTime;
use DateTimeZone;

/**
 * Interface RecurringEventInterface
 * @package Riddlestone\Clockwork\Calendars
 */
interface RecurringEventInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param DateTime $from
     * @param DateTime $to
     * @return RecurringEventInstanceInterface[]
     */
    public function getInstances(DateTime $from, DateTime $to): array;

    /**
     * @return DateTimeZone
     */
    public function getTimeZone(): DateTimeZone;
}
