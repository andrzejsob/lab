<?php
namespace lab\base;

class TemplateHelper
{
    private $template;

    public function __construct($template)
    {
        if(!is_null($template)) {
            $this->template = $template;
            $this->setMessage();
            $this->setUserMenuAndButtons();
        }
    }

    public function setMessage()
    {
        $array = ApplicationHelper::getSessionMessage('message');
        $this->template->assignArray($array);
    }

    public function setUserMenuAndButtons()
  {
        $buttons = array();
        $menu = array();
        $user = ApplicationHelper::getSession()->getUser();
        if ($user) {
            $permArray = $user->getPermissionsArray();
            foreach ($permArray as $name => $description) {
                if (strpos($name, '-')) {
                    $buttons[$name] = $description;
                } else {
                    $menu[$name] = $description;
                }
            }
        }
        $this->template->assignArray(array(
            'buttons' => $buttons,
            'menu' => $menu
        ));
        $this->template->assign('userH', $user);;
    }
}
