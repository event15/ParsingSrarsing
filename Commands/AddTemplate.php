<?php

require_once 'Command.php';
require_once __DIR__ . '/../Message.php';

class AddTemplate implements Command
{
    private $template;
    private $message;

    public function __construct(Message $message, $key = null, $content = null)
    {
        if($key !== null && $content !== null) {
            $this->template = [ $key => $content ];
        } else {
            $this->template = [];
        }
        $this->message  = $message;
    }

    public function execute()
    {
        $this->message->addTemplate($this->template);
    }
}