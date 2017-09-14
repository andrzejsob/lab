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
        $session = ApplicationHelper::getSession();
        $array = ApplicationHelper::getSessionMessage('message');
        $this->template->assignArray($array);

        $user = $session->getUser();
        $menuItemsArray = [];
        $permArray = [];
        if ($user) {
            $permArray = $user->getPermissionsArray();
            $menuItemsArray = array_filter($permArray, function($key) {
                return !strpos($key, '-');
            }, ARRAY_FILTER_USE_KEY);
        }
        $this->assign('menuItems', $menuItemsArray);
        $this->assign('permArray', $permArray);
        $this->assign('cmd', ApplicationHelper::getRequest()->getProperty('cmd'));
        $this->assign('session', \lab\base\ApplicationHelper::getSession());
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
