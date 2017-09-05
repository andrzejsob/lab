<?php
namespace lab\base;

class Redirect{
    public function __construct($path, Message $class = null)
    {
        if(!is_null($class)) {
            $class->setMessage();
        }
        $this->doRedirect($path);
    }

    private function doRedirect($path)
    {
        header("Location: $path");
    }
}
