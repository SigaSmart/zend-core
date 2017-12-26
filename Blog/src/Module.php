<?php
/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Blog;

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
				################ Posts ###################
				\Blog\Model\PostsModel::class => \Blog\Model\Factory\ModelFactory::class,
				\Blog\Table\PostsTable::class => \Blog\Table\Factory\TableFactory::class,
				\Blog\Api\Model\Posts::class => \Blog\Api\Model\Factory\ApiModelFactory::class,
				\Blog\Form\PostsForm::class => \Blog\Form\Factory\FormFactory::class
			]

		];
	}
}