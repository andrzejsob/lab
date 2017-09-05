<?php
namespace lab\command;

use lab\view\Template;
use lab\base\ApplicationHelper;

abstract class Command
{
    protected $variables = array();
    protected $template;

    public function __construct() {
        $this->template = new Template;
        $array = ApplicationHelper::getSessionMessage('message');
        $this->template->assignArray($array);
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
