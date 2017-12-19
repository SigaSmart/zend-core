<?php

namespace Core\Service;


interface MailInterface
{
    public function setSubject($subject);
    public function setTo($to);
    public function setData($data);
    public function setViewTemplate($viewTemplate);
    public function execute();
    public function send();
}