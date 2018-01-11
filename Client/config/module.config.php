<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */
namespace Client;


use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
	'router' => [
		'routes' => [
			"client" => [
				"type" => Literal::class,
				"options" => [
					"route" => "/admin-client",
					"defaults" => [
						"__NAMESPACE__" => "Client\Controller",
						"controller" => "Client",
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
			'Client\Controller\Client' => \Client\Controller\Factory\ControllerFactory::class,
		],
	],
	'view_manager' => [
		'template_path_stack' => [
			__DIR__ . '/../view',
		],
	],
];