<?php

class Serve
{
    private $name;

    private $extension;

    private $type;

    public function __construct($name, $extension)
    {
        $this->name = $name;
        $this->extension = $extension;
    }

    public function processImage()
    {
        switch ($this->extension) {
            case 'png':
                $this->type = 'image/png';
                $this->readImage();
                break;
            case 'jpg':
            case 'jpeg':
                $this->type = 'image/jpeg';
                $this->readImage();
                break;
            default:
                throw new Exception("Error: File extension is not accepted.");
                break;
        }
    }

    private function readImage()
    {
        header('Content-Type:' . $this->type);
        readfile(Config::IMAGE_ROOT . $this->name . '.' . $this->extension);
    }
}
