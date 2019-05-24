<?php

namespace Riddlestone\Clockwork\Calendars;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [

    // MVC
    'router' => [
        'routes' => [
            'calendar' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/calendar',
                    'defaults' => [
                        'controller' => Controller\CalendarController::class,
                        'action' => 'month',
                        'year' => null,
                        'month' => null,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'year' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/:year',
                            'constraints' => [
                                'year' => '[0-9]{4}',
                            ],
                            'defaults' => [
                                'action' => 'year',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'month' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/:year/:month',
                            'constraints' => [
                                'year' => '[0-9]{4}',
                                'month' => '[0-9]{2}',
                            ],
                            'defaults' => [
                                'action' => 'month',
                            ],
                        ],
                    ],
                    'event' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/:year/:month/:event',
                            'constraints' => [
                                'year' => '[0-9]{4}',
                                'month' => '[0-9]{2}',
                                'event' => '[-a-z0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\EventController::class,
                                'action' => 'view',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\CalendarController::class => InvokableFactory::class,
            Controller\EventController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
        'template_path_stack' => [
            __DIR__ . '/../views',
        ],
    ],

    // Module
    'calendars' => [
        'week_starts_on' => 1, // date('N'): 1 = Monday, 7 = Sunday
        'show_out_of_month_days' => true,
        'show_out_of_month_events' => true,
    ],

];
