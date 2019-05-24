<?php

namespace Riddlestone\Clockwork\Calendars\Model;

/**
 * Interface RecurringEventInstanceInterface
 * @package Riddlestone\Clockwork\Calendars
 */
interface RecurringEventInstanceInterface extends EventInterface
{
    /**
     * @return RecurringEventInterface
     */
    public function getRecurringEvent(): RecurringEventInterface;
}
