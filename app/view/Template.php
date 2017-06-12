<?php
namespace lab\view;

class Template
{
    private $vars = array();
    private $layout = 'app/view/layout.php';
    private $file;

    public function assign($var, $value)
    {
        $this->vars[$var] = $value;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function assignArray($array)
    {
        if(!is_null($array)) {
            $this->vars = array_merge($this->vars, $array);
        }
    }

    public function setFile($file)
    {
        if(!is_null($file)) {
            $this->file = $file;
        }
    }

    public function asHtml()
    {
        extract($this->vars);
        ob_start();
        include $this->file;
        $content = ob_get_clean();
        include $this->layout;
        $string = ob_get_contents();
        ob_end_clean();
        echo $string;
        exit ;
    }
}
