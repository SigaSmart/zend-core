<?php

namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\InlineScript;
use Zend\View\Helper\HeadLink;
use Zend\View\Helper\Url;
class ZfImg extends AbstractHelper
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
    public function img()
    {
    	$Url=$this->Url;
		$Params = [
			'controller'=>$this->view->Route()->getController(),
			'action'=>'tag',
			'id'=>$this->view->Route()->getId(),
		];
		$Rota = $Url($this->view->Route()->getRoute(),array_filter($Params));
		$this->inlineScript->captureStart();
			echo "$('.imgContainer').zfImg('{$Rota}');";
		$this->inlineScript->captureEnd();
    }
    public function gallery()
    {
    	$Url=$this->Url;
		$Params = [
			'controller'=>$this->view->Route()->getController(),
			'action'=>'src',
			'id'=>$this->view->Route()->getId(),
		];
		$Rota = $Url($this->view->Route()->getRoute(),$Params);
		$this->inlineScript->captureStart();
			echo "$('#uploadContainer').zfImg('{$Rota}');";
		$this->inlineScript->captureEnd();
    }

}