<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Client;

use Core\Controller\Factory\FactoryController;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'api-client-auth' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/api/auth/client[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'isAuthorizationRequired' => false,
                    ],
                ],
            ],
            'api-client' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/api/client[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ClientController::class,
                        'isAuthorizationRequired' => false,
                    ],
                ],
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => FactoryController::class,
            Controller\ClientController::class => FactoryController::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array', // apc...
                'paths' => [dirname(__DIR__) . '/src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ],
    ]
];
