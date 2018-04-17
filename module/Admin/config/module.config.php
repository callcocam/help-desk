<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin;

use Core\Controller\Factory\FactoryController;
use Zend\Router\Http\Segment;
return [
    'router' => [
        'routes' => [
            'api-auth' =>
                [
                    'type' => Segment::class,
                    'options' => [
                        'route' => '/api/admin[/:id]',
                        'constraints' => [
                            'id' => '[0-9]+',
                        ],
                        'defaults' => [
                            'controller' => Controller\AdminController::class,
                            'isAuthorizationRequired' => false,
                        ],
                    ],
                ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AdminController::class => FactoryController::class
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
