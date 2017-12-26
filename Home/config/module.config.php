<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Home;

use Home\Controller\Factory\ControllerFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
			 'inicio' => [
			 	'type' => Literal::class,
			 	'options' => [
			 		"route" => "/",
			 		"defaults" => [
			 			"__NAMESPACE__" => "Admin\Controller",
			 			"controller" => "Admin",
			 			"action" => "index",
			 		],
			 	],
			 ],
			"home" => [
				"type" => Literal::class,
				"options" => [
					"route" => "/home",
					"defaults" => [
						"__NAMESPACE__" => "Home\Controller",
						"controller" => "Home",
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

			"produtos" => [
				"type" => Literal::class,
				"options" => [
					"route" => "/produtos",
					"defaults" => [
						"__NAMESPACE__" => "Home\Controller",
						"controller" => "Produtos",
						"action" => "index",
					],
				],
				"may_terminate" => true,
				"child_routes" => [
					"default" => [
						"type" => Segment::class,
						"options" => [
							"route" => "/produtos[/:action[/:id]]",
							"constraints" => [
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
			'Home\Controller\Home' => ControllerFactory::class,
			'Home\Controller\Produtos' => ControllerFactory::class,
        ],
    ],
    'view_manager' => [
       'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];