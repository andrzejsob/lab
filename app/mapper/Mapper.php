<?php
namespace lab\mapper;

use lab\domain\ObjectWatcher;
use lab\domain\DomainObject;

abstract class Mapper
{
    protected static $PDO;

    public function __construct()
    {
        if(!isset(self::$PDO)) {
            $database = \lab\base\ApplicationHelper::getDSN();
            if(is_null($database)) {
                throw new \lab\base\AppException("Brak database.");
            }
            $dsn = $database['dsn'];
            $user = $database['user'];
            $password = $database['pass'];
            self::$PDO = new \PDO($dsn, $user, $password);
            self::$PDO->setAttribute(
                \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
    }

    private function getFromMap($id)
    {
        return ObjectWatcher::exists(
            $this->targetClass(),
            $id
        );
    }

    private function addToMap(DomainObject $obj)
    {
        ObjectWatcher::add($obj);
    }

    public function findAll()
    {
        $this->selectAllStmt->execute(array());
        return $this->getCollection(
            $this->selectAllStmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function find($id)
    {
        //$old = $this->getFromMap($id);
        //if (!is_null($old)) {
        //    return $old;
        //}
echo "Mapper::find echo : Odczyt wiersza z bazy \n";
        $this->selectStmt->execute(array($id));
        $array = $this->selectStmt->fetch();
        $this->selectStmt()->closeCursor();
        if(!is_array($array)) {return null;}
        if(!isset($array['id'])) {return null;}
        $object = $this->createObject($array);
        return $object;
    }

    public function createObject($array)
    {
        //$old = $this->getFromMap($array['id']);
        //if (!is_null($old)) {
        //    return $old;
        //}
        $obj = $this->doCreateObject($array);
        //$this->addToMap($obj);
        return $obj;
    }

    public function insert(DomainObject $obj)
    {
        $this->doInsert($obj);
//echo 'Mapper::insert echo : Wstawiam '.$obj->getName()."\n";
//        $this->addToMap($obj);
    }

    abstract public function update(DomainObject $object);
    abstract protected function targetClass();
    abstract protected function doCreateObject(array $array);
    abstract protected function doInsert(DomainObject $object);
    abstract protected function selectStmt();
}
