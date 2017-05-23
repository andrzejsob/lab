<?php
namespace lab\domain;

class HelperFactory
{
    public static function getCollection($class)
    {
        //$collection = '\\'$class.'Collection';
        $class = preg_replace('/^.*\\\/', "", $class);
        $collection = '\\lab\\mapper\\'.$class.'Collection';
        if (class_exists($collection)) {
            return new $collection();
        }
    }

    public static function getFinder($class)
    {
        $class = preg_replace('/^.*\\\/', "", $class);
        $mapper = '\\lab\\mapper\\'.$class.'Mapper';
        //echo $mapper;exit;
        if (class_exists($mapper)) {
            return new $mapper();
        }
    }
}
