<?php
namespace lab\mapper;

abstract class Collection implements \Iterator
{
    protected $mapper;
    protected $total = 0;
    protected $raw = array();
    private $result;
    private $pointer = 0;
    private $objects = array();

    public function __construct(array $raw = null, Mapper $mapper = null)
    {
        if (!is_null($raw) && !is_null($mapper)) {
            $this->raw = $raw;
            $this->total = count($raw);
            $this->mapper = $mapper;
        }
    }

    public function getArray($key = null)
    {
        if (!is_null($key)) {
            $array = array();
            foreach ($this->raw as $rawKey => $array2){
                $array[] = $array2[$key];
            }
            return $array;
        }
        return $this->raw;
    }

    public function add(\lab\domain\DomainObject $object)
    {
        $class = $this->targetClass();
        if(!($object instanceof $class)) {
            throw new Exception('Kolekcja'.$class);
        }
        $this->notifyAccess();
        $this->objects[$this->total] = $object;
        $this->total++;
    }

    abstract public function targetClass();

    protected function notifyAccess()
    {

    }

    private function getRow($num)
    {
        $this->notifyAccess();
        if($num >= $this->total || $num < 0) {
            return null;
        }
        if(isset($this->objects[$num])) {
            return $this->objects[$num];
        }
        if(isset($this->raw[$num])) {
            $this->objects[$num] = $this->mapper->createObject($this->raw[$num]);
        }
        return $this->objects[$num];
    }

    public function rewind()
    {
        $this->pointer = 0;
    }

    public function current()
    {
        return $this->getRow($this->pointer);
    }

    public function key()
    {
        return $this->pointer;
    }

    public function next()
    {
        $row = $this->getRow($this->pointer);
        if($row) {
            $this->pointer++;
        }
        return $row;
    }

    public function valid()
    {
        return !is_null($this->current());
    }
}
