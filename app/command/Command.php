<?php
namespace lab\command;

use lab\view\Template;

abstract class Command
{
    protected $variables = array();
    protected $template;

    public function __construct() {
        $this->template = new Template;
    }

    public function assign($var, $value)
    {
        $this->template->assign($var, $value);
    }

    protected function render($file = null, $array = null)
    {
        $this->template->setFile($file);
        $this->template->assignArray($array);
        $this->template->asHtml();
    }
}
