<?php

namespace Riddlestone\Clockwork\Calendars\Model;

use DateTimeInterface;
use DateTimeZone;

/**
 * Interface EventInterface
 * @package Riddlestone\Clockwork\Calendars
 */
interface EventInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return DateTimeInterface
     */
    public function getStart(): DateTimeInterface;

    /**
     * @return DateTimeInterface
     */
    public function getEnd(): DateTimeInterface;

    /**
     * @return bool
     */
    public function isFullDay(): bool;

    /**
     * @return DateTimeZone
     */
    public function getTimeZone(): DateTimeZone;

    /**
     * @return string
     */
    public function getDescription(): string;
}
