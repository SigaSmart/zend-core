<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Product;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
return [
	'router' => [
		'routes' => [
			"product" => [
				"type" => Literal::class,
				"options" => [
					"route" => "/admin-product",
					"defaults" => [
						"__NAMESPACE__" => "Product\Controller",
						"controller" => "Products",
						"action" => "index",
					],
				],
				"may_terminate" => true,
				"child_routes" => [
					"default" => [
						"type" => Segment::class,
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
			'Product\Controller\Product' => \Product\Controller\Factory\ControllerFactory::class,
			'Product\Controller\Category' => \Product\Controller\Factory\ControllerFactory::class,
			'Product\Controller\Brand' => \Product\Controller\Factory\ControllerFactory::class,
			'Product\Controller\Color' => \Product\Controller\Factory\ControllerFactory::class,
			'Product\Controller\Estoque' => \Product\Controller\Factory\ControllerFactory::class,
		],
	],
	'view_manager' => [
		'template_path_stack' => [
			__DIR__ . '/../view',
		],
	],
];