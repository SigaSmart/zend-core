<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core;

use Auth\Adapter\Authentication;
use Auth\Adapter\AuthenticationFactory;
use Zend\Authentication\AuthenticationService;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
	'router' => [
		'routes' => [
			'FlashMessenger' => [
				'type'    => Segment::class,
				'options' => [
					'route'    => '/flashmessenger[/:action]',
					'constraints' => [
						'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
					],
					'defaults' => [
						'controller'    => Controller\FlashmessengerController::class,
						'action'        => 'index',
					],
				],

			],
		],
	],

	'controllers' => array(
		'factories' => [
			Controller\FlashmessengerController::class => InvokableFactory::class,
		],
	),
	'PRJLog' => [
		'notificationMail' => [
			'notify' => false,
			'priorities' => [
				'0' => 'Emergency',
				'2' => 'Critical',
				'3' => 'Error',
				'4' => 'Warning',
				'5' => 'Debug'
			],
			'email' => 'callcocam@gmail.com'
		]
	],

	'PRJMail' => [
		'transport' => [
			'smtpOptions' => [
				'host' => 'mail.exemplo.com.br',
				'port' => 587,
				'connection_class' => 'plain',
				'connection_config' => [
					'username' => 'contato@exemplo.com.br',
					'password' => 'senhadeacesso',
					'from' => 'exemplo@gmail.com'
				],
			],
			'transportSsl' => [
				'use_ssl' => false,
				'connection_type' => 'tls' // ssl, tls
			],
		],
		'options' => [
			'type' => 'text/html',
			'html_encoding' => \Zend\Mime\Mime::ENCODING_8BIT,
			'message_encoding' => 'UTF8'
		]
	],
	'service_manager' => [
		'invokables' => [
			AuthenticationService::class =>AuthenticationService::class,
		],
		'factories' => [
			'prj-log' => 'Core\Factory\Log',
			'prj-errorhandling' => 'Core\Factory\ErrorHandling',
			'mail-transport' => 'Core\Factory\SmtpTransport',
			'mail-template'  => 'Core\Factory\Template',
			'mail-options'  => 'Core\Factory\Options',
		],

	],



	'view_manager' => [
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map' => [
			//'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
			// 'layout/gentella'           => __DIR__ . '/../view/layout/gentella.phtml',
			// 'layout/layout'           => __DIR__ . '/../view/layout/gentella.phtml',
			'layout/admin-lte'           => __DIR__ . '/../view/layout/admin-lte.phtml',
			//'layout/layout'           => __DIR__ . '/../view/layout/admin-lte.phtml',
			'layout/layout'           => __DIR__ . '/../view/layout/admin-lte-login.phtml',
			'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
			'error/404'               => __DIR__ . '/../view/error/404.phtml',
			'error/index'             => __DIR__ . '/../view/error/index.phtml',
		],
		'template_path_stack' => [
			__DIR__ . '/../view',
		],
	],
];
