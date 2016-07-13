<?php

require_once 'Client.php';

class Export
{
    private $client;
    private $metadata;

    public function __construct($metadata)
    {
        $dto = new ConfigDTO();
            $dto->setLayout('brandpost');
            $dto->setId('1990');
            $dto->setAppearance('regular');
            $dto->setCreated('2016-06-03');
            $dto->setHash('PlidGiVVK');
            $dto->setHeight('450');
            $dto->setWidth('100%');

        $this->metadata = $metadata;
        $this->client   = new Client($dto);
        $this->client->connect('kafka.pl');
    }

    public function execute()
    {
        $this->client->parse($this->metadata);
        echo json_encode($this->client->finalize());
    }
}

$file = file_get_contents('pcMeta.json');

$export = new Export($file);
$export->execute();
