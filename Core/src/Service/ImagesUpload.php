<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 31/12/2017
 * Time: 16:10
 */

namespace Core\Service;



class ImagesUpload  extends ImagesFilter
{
	public function persistFile(array $file, array $data = []) {
		$Type = "images";
		$file['name'] = $this->setFileName($file['name']);
		$filter = $this->addInputFilter($Type,$data['controller'],$data['id']);
		$filter->setData([self::FILE => $file]);
		try {
			if (!$filter->isValid()) {
				$msg = "";
				if (is_array($filter->getMessages())):
					foreach ($filter->getMessages() as $key => $value) {
						$msg.=implode(PHP_EOL, $value);
					}
				else:
					$msg = $filter->getMessages();
				endif;
				$this->result['msg'] = $msg;
				$this->result['result'] = FALSE;
				$this->result['success'] = self::CODE_ERROR;
				return $this->result;
			}
			$filter->getValues();
		} catch (\InvalidArgumentException $e) {
			$this->result['msg'] = $e->getMessage();
			$this->result['result'] = FALSE;
			$this->result['success'] = self::CODE_ERROR;
			return $this->result;
		}
		$this->result['location'] = sprintf("%s%s", $this->getSend(), $file['name']);
		$this->result['msg'] = "IMAGEM {$this->realFolder} ENVIADO COM  SUCESSO!";
		$this->result['result'] = TRUE;
		$this->result['success'] = self::CODE_SUCCESS;
		return $this->result;
	}


}