<?php

namespace Core\Service;


use Interop\Container\ContainerInterface;
use Zend\Log\Logger;

class ErrorHandling
{
    protected $logger;
    protected $serviceLocator;
    
    public function __construct(ContainerInterface $serviceLocator, Logger $logger)
    {
        $this->logger = $logger;
        $this->serviceLocator = $serviceLocator;
    }
    
    /**
     * EMERG   = 0;  // Emergency: system is unusable
     * ALERT   = 1;  // Alert: action must be taken immediately
     * CRIT    = 2;  // Critical: critical conditions
     * ERR     = 3;  // Error: error conditions
     * WARN    = 4;  // Warning: warning conditions
     * NOTICE  = 5;  // Notice: normal but significant condition
     * INFO    = 6;  // Informational: informational messages
     * DEBUG   = 7;  // Debug: debug messages

     * @param \Exception $e
     * @param int $priority
     */
    public function logException(\Exception $e, $priority = 3)
    {
        $trace = $e->getTraceAsString();
        $file = $e->getFile();
        $line = $e->getLine();
        
        $i = 1;
        do {
            $messages[] = $i++ . ": " . $e->getMessage();
        } while ($e = $e->getPrevious());
        
        $log = "\n\nFile:\n" . $file;
        $log .= "\n\nLine: " . $line;
        $log .= "\n\nException:\n" . implode("\n", $messages);
        $log .= "\nTrace:\n\n" . $trace;
        $log .= "\n\n------------------------------------------------------------------------------------------------";
        
        $this->logger->log($priority, $log);
        
        /*
         * Sends an email if the priority of the error is listed in the 
         * configuration ['jvlog'] ['notificationMail'] ['priorities']
         */
        $config = $this->serviceLocator->get('config');
        $notificationMail = $config['PRJLog']['notificationMail'];
        
        if ($notificationMail['notify'])
        {
            $subject = "Erro grave ocorreu no site, prioridade {$notificationMail['priorities'][$priority]}";
            
            $mail = new Mail($this->serviceLocator);
            $mail->setSubject($subject)
            ->setTo($notificationMail['email'])
            ->setData(array('subject' => $subject, 'log' => $log))
            ->setViewTemplate('log-exception')
            ->send();
        }
    }
}