<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core;

use Core\Factory\AclFactory;
use Zend\Authentication\AuthenticationService;
use Zend\Navigation\Service\DefaultNavigationFactory;

return [
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
				'host' => 'mail.sigasmart.com.br',
				'port' => 587,
				'connection_class' => 'plain',
				'connection_config' => [
					'username' => 'contato@sigasmart.com.br',
					'password' => 'vmiq2552mail',
					'from' => 'contato@sigasmart.com.br'
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
			'LayoutListener' => 'Core\Listener\LayoutListener',
			'LayoutErrorListener' => 'Core\Listener\LayoutErrorListener'


		],
		'factories' => [
			'prj-log' => 'Core\Factory\Log',
			'prj-errorhandling' => 'Core\Factory\ErrorHandling',
			'mail-transport' => 'Core\Factory\SmtpTransport',
			'mail-template'  => 'Core\Factory\Template',
			'mail-options'  => 'Core\Factory\Options'
		],

	],

	'view_manager' => [
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map' => [
			'layout/layout'           => __DIR__ . '/../view/layout/home.phtml',
			'core/index/index' => __DIR__ . '/../view/core/index/index.phtml',
			'error/404'               => __DIR__ . '/../view/error/404.phtml',
			'error/index'             => __DIR__ . '/../view/error/index.phtml',
		],
		'strategies' => [
			'ViewJsonStrategy',
		],
		'template_path_stack' => [
			__DIR__ . '/../view',
		],
	],
];
