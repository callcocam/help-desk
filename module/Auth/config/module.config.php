<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Auth;

use Core\Controller\Factory\FactoryController;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'api-auth' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/api/auth[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'isAuthorizationRequired' => false,
                    ],
                ],
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => FactoryController::class,
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
