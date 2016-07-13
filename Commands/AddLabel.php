<?php

require_once 'Command.php';
require_once __DIR__ . '/../Message.php';

class AddLabel implements Command
{
    private $label;
    private $message;

    public function __construct(Message $message, $labelName, $url)
    {
        $this->message = $message;

        $this->label = [
            'name' => $labelName,
            'url' => $url
        ];
    }

    public function execute()
    {
        $this->message->addLabel($this->label);
    }
}