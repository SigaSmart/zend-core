<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Auth;

use Auth\Controller\Factory\AuthControllerFactoy;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
		   'auth' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/admin/auth',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'index',
                    ],
                ],
			   'may_terminate' => true,
			   'child_routes' => [
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
						   'form' => [
							   'type' => Literal::class,
							   'options' => [
								   'route' => '/form',
								   'defaults' => [
									   'action' => 'registerform',
								   ],
							   ],
						   ],
					   ]
				   ],
				   'forgout' => [
					   'type' => Literal::class,
					   'options' => [
						   'route' => '/recuprer-senha',
						   'defaults' => [
							   'action' => 'recuprer-senha',
						   ],
					   ],
				   ],
				   'login' => [
					   'type' => Literal::class,
					   'options' => [
						   'route' => '/login',
						   'defaults' => [
							   'action' => 'login',
						   ],
					   ],
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
