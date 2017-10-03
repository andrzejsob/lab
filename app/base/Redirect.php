<?php
namespace lab\base;

class Redirect{
    public function __construct($path, Message $type = null)
    {
        if(!is_null($type)) {
            $type->setMessage();
        }
        $this->doRedirect($path);
    }

    private function doRedirect($path)
    {
        header("Location: $path");
    }
}
