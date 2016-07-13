<?php

class Message
{
    private $message = [];

    public function addLabel($label)
    {
        if(! $label) {
            throw new \RuntimeException('Nie podano żadnego labela, gdy tego oczekiwano');
        }

        // TODO: parse URL

        $this->message['commands']['labels'][$label['name']] = [
            [
                'getFileToPackage' => $label['url']
            ],
            [
                'getFileName' => 'rekServer'
            ]
        ];
    }

    public function addTemplate($template)
    {
        if(! $template) {
            throw new \RuntimeException('Proszę podać link do wyeksportowanego pliku.');
        }
        
        $this->message['commands']['template'] = [
            $template
        ];
    }

    public function addPacket($packet)
    {
        if (! $packet) {
            throw new \RuntimeException('Musisz podać przynajmniej jedną komendę dla packet.');
        }

        $this->message['commands']['packet'] = [
            $packet
        ];
    }

    public function getMessages()
    {
        return $this->message;
    }

    public function configure($id, $hash, $created, $layout, $appearance, $width, $height)
    {
        if ($this->isValid($id, $hash, $created, $layout, $appearance, $width, $height)) {
            throw new \RuntimeException('Proszę podać wszystkie parametry.');
        }

        $this->message['id'] = $id;

        $this->message['config']['hash']       = $hash;
        $this->message['config']['created']    = $created;
        $this->message['config']['layout']     = $layout;
        $this->message['config']['appearance'] = $appearance;
        $this->message['config']['width']      = $width;
        $this->message['config']['height']     = $height;
    }

    public function addTemplateFile($fileUrl)
    {
        $this->message['templateFile'] = $fileUrl;
    }

    /**
     * @param $id
     * @param $hash
     * @param $created
     * @param $layout
     * @param $appearance
     * @param $width
     * @param $height
     * @return bool
     */
    private function isValid($id, $hash, $created, $layout, $appearance, $width, $height)
    {
        return !$id || !$hash || !$created || !$layout || !$appearance || !$width || !$height;
    }
}