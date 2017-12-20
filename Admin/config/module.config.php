<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Admin\Controller\Factory\ControllerFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
			'home' => [
				'type' => Literal::class,
				'options' => [
					'route'    => '/',
					'defaults' => [
						'controller' => Controller\AdminController::class,
						'action'     => 'index',
					],
				],
			],
            'admin' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/admin',
                    'defaults' => [
                        'controller' => Controller\AdminController::class,
                        'action'     => 'index',
                    ],
                ],
				
            ],
            'default' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/admin[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\AdminController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
			'cidades' => [
				'type' => Literal::class,
				'options' => [
					'route'    => '/admin/cidade',
					'defaults' => [
						'controller' => Controller\CidadeController::class,
						'action'     => 'index',
					],
				],
				'may_terminate' => true,
				'child_routes' => [
					'cidades-table' => [
						'type' => Literal::class,
						'options' => [
							'route' => '/cidades-table',
							'defaults' => [
								'action' => 'test',
							],
						],
					],
				]
			],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AdminController::class => ControllerFactory::class,
            Controller\CidadeController::class => ControllerFactory::class,
        ],
    ],
    'view_manager' => [
       'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
