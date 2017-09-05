<?php
namespace lab\base;

class Success extends Message
{
    public function setMessage()
    {
        $this->session->setVariable(
            'message',
            'success_'.$this->message
        );
    }
}
