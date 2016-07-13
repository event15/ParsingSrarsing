<?php

require_once 'Command.php';
require_once __DIR__ . '/../Message.php';

class AddPacket implements Command
{
    private $packet;

    /**
     * AddPacket constructor.
     * @param $packetName
     * @param $value
     */
    public function __construct($packetName, $value)
    {
        $this->packet = [ $packetName => $value ];
    }

    public function execute()
    {
        $message = new Message();
        $message->addPacket($this->packet);
    }
}