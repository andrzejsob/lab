<?php
namespace lab\command;

class CommandResolver
{
    private static $defaultCmd;

    public function resolveCommand(\lab\controller\Request $request)
    {
        $cmd = $request->getProperty('cmd');
        list($class, $action) = explode('-',$cmd);
        $class_array = explode('_', $class);
        $class_array[0] = ucfirst($class_array[0]);
        if (array_key_exists(1, $class_array)) {
            $class_array[1] = ucfirst($class_array[1]);
        }
        $array[] = '\\lab\\command\\'.implode($class_array).'Command';
        $array[] = $action.'Action';
        return $array;
    }
}
