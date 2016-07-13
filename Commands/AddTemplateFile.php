<?php

require_once 'Command.php';
require_once __DIR__ . '/../Message.php';

class AddTemplateFile implements Command
{
    private $message;
    private $templateFile;

    public function __construct(Message $message, $templateFile)
    {
        $this->message      = $message;
        $this->templateFile = $templateFile;
    }

    public function execute()
    {
        $this->message->addTemplateFile($this->templateFile);
    }
}