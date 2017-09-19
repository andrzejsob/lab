<?php
namespace lab\command;

use lab\view\Template;
use lab\base\TemplateHelper;

abstract class Command
{
    protected $template;

    public function __construct() {
        $this->template = new Template;
        $tHelper = new TemplateHelper($this->template);
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
