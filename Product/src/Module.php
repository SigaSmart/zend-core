<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 05/01/2018
 * Time: 16:28
 */

namespace Product;


use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{

	/**
	 * Returns configuration to merge with application configuration
	 *
	 * @return array|\Traversable
	 */
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
		//factories
			'factories'=>[
				
				################ Product ###################
				\Product\Model\ProductModel::class => \Product\Model\Factory\ModelFactory::class,
				\Product\Table\ProductTable::class => \Product\Table\Factory\TableFactory::class,
				\Product\Api\Model\Product::class => \Product\Api\Model\Factory\ApiModelFactory::class,
				\Product\Form\ProductForm::class => \Product\Form\Factory\FormFactory::class,

				################ Category ###################
				\Product\Model\CategoryModel::class => \Product\Model\Factory\ModelFactory::class,
				\Product\Table\CategoryTable::class => \Product\Table\Factory\TableFactory::class,
				\Product\Api\Model\Category::class => \Product\Api\Model\Factory\ApiModelFactory::class,
				\Product\Form\CategoryForm::class => \Product\Form\Factory\FormFactory::class,

				################ Brand ###################
				\Product\Model\BrandModel::class => \Product\Model\Factory\ModelFactory::class,
				\Product\Table\BrandTable::class => \Product\Table\Factory\TableFactory::class,
				\Product\Api\Model\Brand::class => \Product\Api\Model\Factory\ApiModelFactory::class,
				\Product\Form\BrandForm::class => \Product\Form\Factory\FormFactory::class,

				################ Color ###################
				\Product\Model\ColorModel::class => \Product\Model\Factory\ModelFactory::class,
				\Product\Table\ColorTable::class => \Product\Table\Factory\TableFactory::class,
				\Product\Api\Model\Color::class => \Product\Api\Model\Factory\ApiModelFactory::class,
				\Product\Form\ColorForm::class => \Product\Form\Factory\FormFactory::class,

				################ Estoque ###################
				\Product\Model\EstoqueModel::class => \Product\Model\Factory\ModelFactory::class,
				\Product\Table\EstoqueTable::class => \Product\Table\Factory\TableFactory::class,
				\Product\Api\Model\Estoque::class => \Product\Api\Model\Factory\ApiModelFactory::class,
				\Product\Form\EstoqueForm::class => \Product\Form\Factory\FormFactory::class
				
			]
			//invokables
		];
	}
}