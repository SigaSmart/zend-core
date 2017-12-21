<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Auth;

use Auth\Controller\Factory\ControllerFactoy;
use Zend\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
			"auth" => [
				"type" => Literal::class,
				"options" => [
					"route" => "/admin-auth",
					"defaults" => [
						"__NAMESPACE__" => "Auth\Controller",
						"controller" => "Auth",
						"action" => "login",
					],
				],
				"may_terminate" => true,
				"child_routes" => [
					"default" => [
						"type" => "Segment",
						"options" => [
							"route" => "/[:controller[/:action[/:id]]]",
							"constraints" => [
								"controller" => "[a-zA-Z][a-zA-Z0-9_-]*",
								"action" => "[a-zA-Z][a-zA-Z0-9_-]*",
							],
							"defaults" => [
							],
						],
					],
				],
			],
        ],
    ],
    'controllers' => [
        'factories' => [
			'Auth\Controller\Auth' => ControllerFactoy::class,
        ],
    ],
    'view_manager' => [
       'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
