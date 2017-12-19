<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Auth;

use Auth\Controller\Factory\AuthControllerFactoy;
use Zend\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
		   'auth' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/admin/auth',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'login',
                    ],
                ],
			   'may_terminate' => true,
			   'child_routes' => [
				   'login-form' => [
					   'type' => Literal::class,
					   'options' => [
						   'route' => '/login-form',
						   'defaults' => [
							   'action' => 'login-form',
						   ],
					   ],
				   ],
				   // Segment route for viewing one blog post
				   'register' => [
					   'type' => Literal::class,
					   'options' => [
						   'route' => '/register',
						   'defaults' => [
							   'action' => 'register',
						   ],
					   ],
					   'may_terminate' => true,
					   'child_routes' => [
						   'register-form' => [
							   'type' => Literal::class,
							   'options' => [
								   'route' => '/register-form',
								   'defaults' => [
									   'action' => 'register-form',
								   ],
							   ],
						   ],
					   ]
				   ],
				    'recuperar-senha' => [
					   'type' => Literal::class,
					   'options' => [
						   'route' => '/recuperar-senha',
						   'defaults' => [
							   'action' => 'recuperar-senha',
						   ],
					   ],
						'may_terminate' => true,
						'child_routes' => [
							'recuperar-senha-form' => [
								'type' => Literal::class,
								'options' => [
									'route' => '/recuperar-senha-form',
									'defaults' => [
										'action' => 'recuperar-senha-form',
									],
								],
							],
						]
				   ],

			   ]
            ],

        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => AuthControllerFactoy::class,
        ],
    ],
    'view_manager' => [
       'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
