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
        $plugin   = $this->flashMessenger->getPluginFlashMessenger();
		if($plugin->hasMessages('redirect')):
			$Route=$plugin->getMessagesFromNamespace('redirect');
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
				echo 'setTimeout(function () {
					window.location.href = "'.$this->view->url($Route[0]).'";
				 }, 3000);';
			endif;
        $this->inlineScript->captureEnd();
    }
    
   

}