<?php

require_once 'Command.php';
require_once __DIR__ . '/../Message.php';

class ConfigureOptions implements Command
{
    private $message;
    private $config;

    public function __construct(Message $message, ConfigDTO $config)
    {
        $this->message = $message;
        $this->config  = $config;
    }

    public function execute()
    {
        $this->message->configure(
            $this->config->getId(),
            $this->config->getHash(),
            $this->config->getCreated(),
            $this->config->getLayout(),
            $this->config->getAppearance(),
            $this->config->getWidth(),
            $this->config->getHeight()
        );
    }
}