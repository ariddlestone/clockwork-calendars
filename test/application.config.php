<?php

return [
    'modules' => [
        'Zend\\Router',
        'Riddlestone\\Clockwork\\Calendars'
    ],
    'module_listener_options' => [
        'module_paths' => [
            __DIR__ . '/../vendor',
        ],
        'config_glob_paths' => [
            __DIR__ . '/test.config.php',
        ],
        'config_cache_enabled' => false,
        'config_cache_key' => 'application.config.cache',
        'module_map_cache_enabled' => false,
        'module_map_cache_key' => 'application.module.cache',
        'cache_dir' => 'data/cache/',
    ],
];
