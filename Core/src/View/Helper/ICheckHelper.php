<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 21/12/2017
 * Time: 18:35
 */

namespace Core\View\Helper;


use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\HeadLink;
use Zend\View\Helper\InlineScript;
use Zend\View\Helper\Url;

class ICheckHelper extends AbstractHelper
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

    public function __invoke()
	{
		$this->inlineScript->captureStart();
		echo  "$(function () {
					$('.checkbox-toggle').click(function () {
						var clicks = $(this).data('clicks');
						if (clicks) {
							//Uncheck all checkboxes
							$('.box-body input[type='checkbox']').iCheck('uncheck');
							$('.fa', this).removeClass('fa-check-square-o').addClass('fa-square-o');
						} else {
							//Check all checkboxes
							$('.box-body input[type='checkbox']').iCheck('check');
							$('.fa', this).removeClass('fa-square-o').addClass('fa-check-square-o');
						}
						$(this).data('clicks', !clicks);
					});
				});";
		$this->inlineScript->captureEnd();
	}
}