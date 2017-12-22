<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Admin\Api\Model\Cidade;
use Admin\Api\Model\Factory\ApiModelFactory;
use Admin\Form\CidadeForm;
use Admin\Form\Factory\FormFactory;
use Admin\Model\CidadeModel;
use Admin\Model\Factory\ModelFactory;
use Admin\Table\CidadeTable;
use Admin\Table\Factory\TableFactory;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements ServiceProviderInterface
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

	/**
	 * Expected to return \Zend\ServiceManager\Config object or array to
	 * seed such an object.
	 *
	 * @return array|\Zend\ServiceManager\Config
	 */
	public function getServiceConfig()
	{
		return [

			'factories'=>[
				CidadeModel::class => ModelFactory::class,
				CidadeTable::class => TableFactory::class,
				Cidade::class => ApiModelFactory::class,
				CidadeForm::class =>FormFactory::class
			]
		];
	}
}
