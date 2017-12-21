<?php

namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\InlineScript;
use Zend\View\Helper\HeadLink;
use Zend\View\Helper\Url;
class ZfTable extends AbstractHelper
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


    public function listar()
    {
    	echo '<div id="tableContainer" ></div>';
		$Url=$this->Url;
		$Params = [
			'controller'=>$this->view->Route()->getController(),
			'action'=>'listar',
			'id'=>$this->view->Route()->getId(),
		];
		$Rota = $Url($this->view->Route()->getRoute(),array_filter($Params));
		$this->inlineScript->captureStart();
			echo "$('#tableContainer').zfTable('{$Rota}');";
		$this->inlineScript->captureEnd();
    }
	public function person($Container,$route,$controller,$action,$id="")
	{
		$Url=$this->Url;
		$Params = [
			'controller'=>$controller,
			'action'=>$action,
			'id'=>$id,
		];

		$Rota = $Url($route,array_filter($Params));
		$this->inlineScript->captureStart();
		echo "$('#{$Container}').zfTable({$Rota});";
		$this->inlineScript->captureEnd();
	}
    
   

}