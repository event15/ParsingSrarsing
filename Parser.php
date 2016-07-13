<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Message.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Commands/AddLabel.php';

class Parser
{
    private $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function execute($pcMeta)
    {
        $pcMeta = json_decode($pcMeta, true);
        $count  = 0;

        array_walk_recursive($pcMeta, function (&$url) use (& $count) {
            if (!$this->isImage($url)) {
                return;
            }

            $label = "~IMG{$count}~";

            $kafka = new AddLabel($this->message, $label, $url);
            $kafka->execute();

            $count++;
            $url = $label;
        });

        return json_encode($pcMeta);
    }

    /**
     * @param $url
     * @return bool
     */
    private function isImage($url)
    {
        $image = explode('.', $url);
        $image = end($image);

        return ($image === 'jpg' || $image === 'png');
    }
}