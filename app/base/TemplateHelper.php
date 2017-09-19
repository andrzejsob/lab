<?php
namespace lab\base;

class TemplateHelper
{
    private $template;

    public function __construct($template)
    {
        if(!is_null($template)) {
            $this->template = $template;
            $this->setVars();
        }
    }

    public function setVars()
    {
        $this->setMessageVar();
        $this->setUserVars();
    }

    public function setMessageVar()
    {
        $array = ApplicationHelper::getSessionMessage('message');
        $this->template->assignArray($array);
    }

    public function setUserVars()
    {
        $menuItemsArray = [];
        $permArray = [];
        $user = ApplicationHelper::getSession()->getUser();
        if ($user) {
            $permArray = $user->getPermissionsArray();
            $menuItemsArray = array_filter($permArray, function($key) {
                return !strpos($key, '-');
            }, ARRAY_FILTER_USE_KEY);
        }
        $this->template->assign('menuItems', $menuItemsArray);
        $this->template->assign('permArray', $permArray);
        $this->template->assign('user', $user);
        $this->template->assign('cmd', ApplicationHelper::getRequest()->getProperty('cmd'));
    }
}
