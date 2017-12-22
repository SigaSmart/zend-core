<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin;

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
				################ Cidade ###################
				\Admin\Model\CidadeModel::class => \Admin\Model\Factory\ModelFactory::class,
				\Admin\Table\CidadeTable::class => \Admin\Table\Factory\TableFactory::class,
				\Admin\Api\Model\Cidade::class => \Admin\Api\Model\Factory\ApiModelFactory::class,
				\Admin\Form\CidadeForm::class => \Admin\Form\Factory\FormFactory::class,

				################ Empresa ###################
				\Admin\Model\EmpresaModel::class => \Admin\Model\Factory\ModelFactory::class,
				\Admin\Table\EmpresaTable::class => \Admin\Table\Factory\TableFactory::class,
				\Admin\Api\Model\Empresa::class => \Admin\Api\Model\Factory\ApiModelFactory::class,
				\Admin\Form\EmpresaForm::class => \Admin\Form\Factory\FormFactory::class,


			]
		];
	}
}
