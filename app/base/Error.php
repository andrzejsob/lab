<?php
namespace lab\base;

class Error extends Message
{
    public function setMessage()
    {
        $this->session->setVariable(
            'message',
            'error_'.$this->message
        );
    }
}
