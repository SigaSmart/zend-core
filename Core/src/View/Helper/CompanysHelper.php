<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 04/01/2018
 * Time: 08:04
 */

namespace Core\View\Helper;


use Admin\Table\EmpresaTable;
use Auth\Adapter\Authentication;
use Interop\Container\ContainerInterface;
use Zend\View\Helper\AbstractHelper;

class CompanysHelper extends AbstractHelper
{
	protected $companys;
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * CompanysHelper constructor.
	 *
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->companys['email']="contato@sigasmart.com.br";
		$this->companys['phone']="(48)3535-1603";
		$this->companys['street']="Oscar de oliveira lopes";
		$this->companys['zip']="88950-000";
		$this->companys['number']="355";
		$this->companys['state']="SC";
		$this->companys['district']="Bela Vista";
		$this->companys['city']="Jacinto Machado";
		$this->companys['country']="Brasil";
		$this->container = $container;
		$user = $this->container->get(Authentication::class)->getIdentity();
		if($user):
		$this->companys = $this->container->get(EmpresaTable::class)->find($user->empresa);
		endif;
		$this->companys['fantasia']="SIGA-SMART";
		$this->companys['title']="SIGA-SMART";
		$this->companys['description']="Sistema Inteligente de Gerenciamento e Admistração!";
		$this->companys['preview']="Sistema Inteligente de Gerenciamento e Admistração!";
		$this->companys['cover']="img/default.jpg";
		$this->companys['gg_autor']="114670982115068448665";
		$this->companys['gg_publisher']="114670982115068448665";
		$this->companys['fb_autor']="claudio.coelho.175";
		$this->companys['fb_publisher']="claudio.coelho.175";
		$this->companys['twitter']="callcocam";
		$this->companys['fb_api']="158331894710694";
	}

	/**
	 * @return mixed
	 */
	public function __invoke()
	{
		return $this->companys;
	}
}