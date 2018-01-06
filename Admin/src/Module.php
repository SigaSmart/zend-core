<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Admin;


use Interop\Container\ContainerInterface;
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

				################ Produto ###################
				\Admin\Model\ProdutoModel::class => \Admin\Model\Factory\ModelFactory::class,
				\Admin\Table\ProdutoTable::class => \Admin\Table\Factory\TableFactory::class,
				\Admin\Api\Model\Produto::class => \Admin\Api\Model\Factory\ApiModelFactory::class,
				\Admin\Form\ProdutoForm::class => \Admin\Form\Factory\FormFactory::class,

				################ Menu ###################
				\Admin\Model\MenuModel::class => \Admin\Model\Factory\ModelFactory::class,
				\Admin\Table\MenuTable::class => \Admin\Table\Factory\TableFactory::class,
				\Admin\Api\Model\Menu::class => \Admin\Api\Model\Factory\ApiModelFactory::class,
				\Admin\Form\MenuForm::class => \Admin\Form\Factory\FormFactory::class,

				################ Role ###################
				\Admin\Model\RoleModel::class => \Admin\Model\Factory\ModelFactory::class,
				\Admin\Table\RoleTable::class => \Admin\Table\Factory\TableFactory::class,
				\Admin\Api\Model\Role::class => \Admin\Api\Model\Factory\ApiModelFactory::class,
				\Admin\Form\RoleForm::class => \Admin\Form\Factory\FormFactory::class,

				################ Privilege ###################
				\Admin\Model\PrivilegeModel::class => \Admin\Model\Factory\ModelFactory::class,
				\Admin\Table\PrivilegeTable::class => \Admin\Table\Factory\TableFactory::class,
				\Admin\Api\Model\Privilege::class => \Admin\Api\Model\Factory\ApiModelFactory::class,
				\Admin\Form\PrivilegeForm::class => \Admin\Form\Factory\FormFactory::class,

				################ Resource ###################
				\Admin\Model\ResourceModel::class => \Admin\Model\Factory\ModelFactory::class,
				\Admin\Table\ResourceTable::class => \Admin\Table\Factory\TableFactory::class,
				\Admin\Api\Model\Resource::class => \Admin\Api\Model\Factory\ApiModelFactory::class,
				\Admin\Form\ResourceForm::class => \Admin\Form\Factory\FormFactory::class,

				################ User ###################
				\Admin\Model\UserModel::class => \Admin\Model\Factory\ModelFactory::class,
				\Admin\Table\UserTable::class => \Admin\Table\Factory\TableFactory::class,
				\Admin\Api\Model\User::class => \Admin\Api\Model\Factory\ApiModelFactory::class,
				\Admin\Form\UserForm::class => \Admin\Form\Factory\FormFactory::class,

				################ Gallery ###################
				\Admin\Model\GalleryModel::class => \Admin\Model\Factory\ModelFactory::class,
				\Admin\Table\GalleryTable::class => \Admin\Table\Factory\TableFactory::class,
				\Admin\Api\Model\Gallery::class => \Admin\Api\Model\Factory\ApiModelFactory::class,
				\Admin\Form\GalleryForm::class => \Admin\Form\Factory\FormFactory::class,
				\Admin\Form\UploadForm::class => \Admin\Form\Factory\FormFactory::class,
				\Admin\Form\ModuleForm::class => \Admin\Form\Factory\FormFactory::class,
				\Core\Service\ImagesUpload::class => function(ContainerInterface $container){
					return new \Core\Service\ImagesUpload($container);
				},


			]
		];
	}
}
