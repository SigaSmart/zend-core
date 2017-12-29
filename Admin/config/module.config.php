<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin;

use Admin\Controller\Factory\ControllerFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
			"admin" => [
				"type" => Literal::class,
				"options" => [
					"route" => "/admin",
					"defaults" => [
						"__NAMESPACE__" => "Admin\Controller",
						"controller" => "Admin",
						"action" => "index",
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
			'Admin\Controller\Admin' => ControllerFactory::class,
			'Admin\Controller\Cidade' => ControllerFactory::class,
			'Admin\Controller\Empresa' => ControllerFactory::class,
			'Admin\Controller\Produto' => ControllerFactory::class,
			'Admin\Controller\Menu' => ControllerFactory::class,
			'Admin\Controller\Role' => ControllerFactory::class,
			'Admin\Controller\Privilege' => ControllerFactory::class,
			'Admin\Controller\Resource' => ControllerFactory::class,
			'Admin\Controller\User' => ControllerFactory::class,
        ],
    ],
    'view_manager' => [
       'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
