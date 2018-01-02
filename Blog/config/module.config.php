<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Blog;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
			"blog" => [
				"type" => Literal::class,
				"options" => [
					"route" => "/admin-blog",
					"defaults" => [
						"__NAMESPACE__" => "Blog\Controller",
						"controller" => "Posts",
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
			'Blog\Controller\Posts' => \Blog\Controller\Factory\ControllerFactory::class,
			'Blog\Controller\Categorie' => \Blog\Controller\Factory\ControllerFactory::class,
        ],
    ],
    'view_manager' => [
       'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];