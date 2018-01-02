<?php

namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\InlineScript;
use Zend\View\Helper\HeadLink;
use Zend\View\Helper\Url;
class ZfForm extends AbstractHelper
{

	private $inlineScript;
	private $Url;
	private $headLink;
	public function __construct(InlineScript $inlineScript,HeadLink $headLink,Url $Url)
	{

		$this->inlineScript   = $inlineScript;
		$this->headLink=$headLink;
		$this->Url=$Url;

	}
	public function form($Id = null)
	{
		$users = $this->view->identity();
		if($users):
			$acl = $this->view->Acl()->getAcl();
			$pemission = $acl->isAllowed($users->access,$this->view->Route()->getParan('controller'),$this->view->Route()->getAction());
			if(!$pemission):
				return;
			endif;
		endif;
		if(!$Id):
			$Id = $this->view->Route()->getId();
		endif;
		$Url=$this->Url;
		$Params = [
			'controller'=>$this->view->Route()->getController(),
			'action'=>sprintf("%s-form", $this->view->Route()->getAction()),
			'id'=>$Id,
		];
		$Rota = $Url($this->view->Route()->getRoute(),array_filter($Params));
		$this->inlineScript->captureStart();
		echo "$('#formContainer').zfForm('{$Rota}');";
		$this->inlineScript->captureEnd();

	}
	public function upload($Id = null)
	{
		$users = $this->view->identity();
		if($users):
			$acl = $this->view->Acl()->getAcl();
			$pemission = $acl->isAllowed($users->access,$this->view->Route()->getParan('controller'),$this->view->Route()->getAction());
			if(!$pemission):
				return;
			endif;
		endif;
			if(!$Id):
				$Id = $this->view->Route()->getId();
			endif;
			$Url=$this->Url;
			$Params = [
				'controller'=>$this->view->Route()->getController(),
				'action'=>'upload',
				'id'=>$Id,
			];
			$Rota = $Url($this->view->Route()->getRoute(),$Params);
			$this->inlineScript->captureStart();
			echo "$('#uploadContainer').zfForm('{$Rota}');";
			$this->inlineScript->captureEnd();

	}
	public function person($Container,$route,$controller,$action,$id="")
	{
		$users = $this->view->identity();
		if($users):
			$acl = $this->view->Acl()->getAcl();
			$pemission = $acl->isAllowed($users->access,$this->view->Route()->getParan('controller'),$this->view->Route()->getAction());
			if(!$pemission):
				return;
			endif;
		endif;
		$Url=$this->Url;
		$Params = [
			'controller'=>$controller,
			'action'=>$action,
			'id'=>$id,
		];
		$Rota = $Url($route,array_filter($Params));
		$this->inlineScript->captureStart();
		echo "$('#{$Container}').zfForm('{$Rota}');";
		$this->inlineScript->captureEnd();
	}

	public function tinyMce($Seletor,$Id = null)
	{

		if(!$Id):
			$Id = $this->view->Route()->getId();
		endif;
		$Url=$this->Url;
		$Params = [
			'controller'=>$this->view->Route()->getController(),
			'action'=>'up',
			'id'=>$Id,
		];
		$Rota = $Url($this->view->Route()->getRoute(),$Params);
		$this->inlineScript->captureStart();
		echo "$('#{$Seletor}').zfTiny('{$Rota}');";
		$this->inlineScript->captureEnd();

	}
}