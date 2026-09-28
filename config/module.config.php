<?php declare(strict_types=1);

namespace ItemCopy;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Service\Controller\IndexControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'item-copy' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin/item-copy',
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'default' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/:id',
                            'constraints' => [
                                'id' => '[1-9][0-9]*',
                            ],
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action' => 'copy',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
