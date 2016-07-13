<?php

require_once 'ConfigDTO.php';
require_once 'Commands/ConfigureOptions.php';
require_once 'Message.php';
require_once 'Parser.php';
require_once 'Commands/AddTemplateFile.php';
require_once 'Commands/AddTemplate.php';
require_once 'Commands/AddPacket.php';

class Client
{
    private $instance;
    private $messageManager;

    public function __construct(ConfigDTO $config)
    {
        $this->messageManager = new Message();
        $this->configure($config);
    }

    private function configure(ConfigDTO $config)
    {
        $producer = new ConfigureOptions($this->messageManager, $config);
        $producer->execute();
    }

    private function setTemplate()
    {
        $template = new AddTemplate($this->messageManager);
        $template->execute();
    }

    private function setTemplateFile()
    {
        $templateFile = new AddTemplateFile($this->messageManager, 'export.html');
        $templateFile->execute();
    }

    private function setPacket()
    {
        $packet = new AddPacket('sendMail', 'marwo12@gmail.com');
        $packet->execute();
    }

    public function connect($toBroker, $port = 3000, $requireAck = -1)
    {
        if (!$toBroker) {
            throw new \RuntimeException('Broker nie może być pusty.');
        }

        try {
            // $this->instance = \Kafka\Produce::getInstance("{$toBroker}:{$port}", 3000);
            // $this->instance->setRequireAck($requireAck);

            $this->instance = [ 'broker' => $toBroker . ':' . $port ];

        } catch (\RuntimeException $connectionException) {
            throw new \RuntimeException(
                sprintf("Błąd w czasie łączenia z Brokerem: %s", $connectionException->getMessage())
            );
        }
    }

    public function parse($metadata)
    {
        $parser = new Parser($this->messageManager);

        return $parser->execute($metadata);
    }

    private function generateExport($parsedMetadata)
    {
        // TODO: generowanie
    }

    public function finalize()
    {
        $this->setTemplateFile();
        $this->setTemplate();
        $this->setPacket();

        $this->instance['send'] = $this->messageManager->getMessages();

        return $this->instance;
    }
}