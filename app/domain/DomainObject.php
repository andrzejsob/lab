<?php
namespace lab\domain;

abstract class DomainObject
{
    private $id;

    public function __construct($id = null)
    {
        if (is_null($id)) {
            $this->markNew();
        } else {
            $this->id = $id;
        }
    }

    public function getProperty($name)
    {
        return $this->name;
    }

    public function markNew()
    {
        ObjectWatcher::addNew($this);
    }

    public function markDeleted()
    {
        ObjectWatcher::addDelete($this);
    }

    public function markDirty()
    {
        ObjectWatcher::addDirty($this);
    }

    public function markClean()
    {
        ObjectWatcher::addClean($this);
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function finder()
    {
        return self::getFinder(get_class($this));
    }

    public static function getFinder($type = null)
    {
//echo 'DomainObject::getFinder->type : '.$type."\n";
//echo 'DomainObject::getFinder->get_called_class() : '.get_called_class()."\n";
        if (is_null($type)) {
            return HelperFactory::getFinder(get_called_class());
        }
        return HelperFactory::getFinder($type);
    }

    public static function find($id)
    {
        $finder = self::getFinder();
        $object = $finder->find($id);

        return $object;
    }

    public function save()
    {
        $finder = self::getFinder();
        if (is_null($this->getId())) {
            $finder->insert($this);
        } else {
            $finder->update($this);
        }
    }

    public function update()
    {
        self::getFinder()->update($this);
    }

    public static function getCollection($type = null)
    {
        if (is_null($type)) {
            return HelperFactory::getCollection(get_called_class());
        }
        return HelperFactory::getCollection($type);
    }

    public function collection()
    {
        return self::getCollection(get_class($this));
    }
}
