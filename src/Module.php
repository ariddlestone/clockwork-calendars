<?php

namespace Riddlestone\Clockwork\Calendars;

/**
 * Class Module
 * @package Riddlestone\Clockwork\Calendars
 */
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
