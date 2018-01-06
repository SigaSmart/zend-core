<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Webblog;

use Webblog\Controller\Factory\ControllerFactoy;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
			"home" => [
				"type" => Literal::class,
				"options" => [
					"route" => "/",
					"defaults" => [
						"__NAMESPACE__" => "Webblog\Controller",
						"controller" => "Home",
						"action" => "index",
					],
				],

			],"web" => [
				"type" => Literal::class,
				"options" => [
					"route" => "/",
					"defaults" => [
						"__NAMESPACE__" => "Webblog\Controller",
						"controller" => "Home",
						"action" => "index",
					],
				],

			],
			"web-blog" => [
				"type" => Segment::class,
				"options" => [
					"route" => "/blog[/:action[/:slug[/:page]]]",
					'constraints' => [
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id'     => '[a-zA-Z][a-zA-Z0-9_-]*',
					],
					"defaults" => [
						"__NAMESPACE__" => "Webblog\Controller",
						"controller" => "Home",
						"action" => "posts",
					],
				],

			],

        ],
    ],
    'controllers' => [
        'factories' => [
			'Webblog\Controller\Home' => ControllerFactoy::class,
        ],
    ],
    'view_manager' => [
       'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];