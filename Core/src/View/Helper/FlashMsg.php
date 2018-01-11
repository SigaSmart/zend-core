<?php

namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\InlineScript;
use Zend\View\Helper\HeadLink;
use Zend\View\Helper\Url;
class FlashMsg extends AbstractHelper
{
    private $flashMessenger;
    private $inlineScript;
    private $Url;
    private $headLink;
    public function __construct( $flashMessenger, InlineScript $inlineScript,HeadLink $headLink,Url $Url)
    {
        
        $this->flashMessenger = $flashMessenger;
        $this->inlineScript   = $inlineScript;
        $this->headLink=$headLink;
        $this->Url=$Url;

    }

    /**
     * Collect all messages from previous and current request
     * clear current messages because we will show it
     * add JS files
     * add JS notifications
     */
    public function __invoke()
    {
        $Url = $this->Url;
        $Route=[];
        $Time=3000;
        $plugin   = $this->flashMessenger->getPluginFlashMessenger();
		if($plugin->hasMessages('time')):
			$Time = $plugin->getMessagesFromNamespace('time')[0];
		endif;
			if($plugin->hasMessages('redirect')):
			$Redirect=$plugin->getMessagesFromNamespace('redirect')[0];
			if(is_string($Redirect)):
				$Route[0]=$Redirect;
				$Route[1]=[];
			else:
				$Route=$Redirect;
				if(!isset($Redirect[1])):
					$Route[1]=[];
				endif;
			endif;

			$plugin->clearCurrentMessages('redirect');
		endif;

        $noty     = [
            'alert'       => array_merge($plugin->getMessages(), $plugin->getCurrentMessages()),
            'information' => array_merge($plugin->getInfoMessages(), $plugin->getCurrentInfoMessages()),
            'success'     => array_merge($plugin->getSuccessMessages(), $plugin->getCurrentSuccessMessages()),
            'warning'     => array_merge($plugin->getWarningMessages(), $plugin->getCurrentWarningMessages()),
            'error'       => array_merge($plugin->getErrorMessages(), $plugin->getCurrentErrorMessages()),
         ];

        $plugin->clearCurrentMessages('default');
        $plugin->clearCurrentMessages('info');
        $plugin->clearCurrentMessages('success');
        $plugin->clearCurrentMessages('warning');
        $plugin->clearCurrentMessages('error');
        $plugin->clearCurrentMessages('danger');

        $this->inlineScript->captureStart();
        foreach(array_filter($noty) as $type => $messages){
            $message = implode('<br/><br/>', $messages);
            $message = preg_replace('/\s+/', ' ', $message);
            switch($type){
                case "alert":echo 'toastr.info("'.$message.'");';break;
                case "information":echo 'toastr.info("'.$message.'");';break;
                case "success":echo 'toastr.success("'.$message.'");';break;
                case "warning":echo 'toastr.warning("'.$message.'");';break;
                case "error":echo 'toastr.error("'.$message.'");';break;
              }
            
        }
		if($Route):
			echo sprintf('setTimeout(function () {
					window.location.href = "%s";
				 }, %s);',$this->view->url($Route[0],$Route[1]), $Time);
		endif;
        $this->inlineScript->captureEnd();
    }
    
   

}