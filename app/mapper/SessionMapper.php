<?php
namespace lab\mapper;

use \lab\domain\DomainObject;
use \lab\domain\User;

class SessionMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectAllStmt = self::$PDO->prepare(
            'SELECT * FROM user');
        $this->findBySessionAsciiStmt = self::$PDO->prepare(
            "SELECT * FROM session WHERE session_ascii_id = ?");
        $this->insertStmt = self::$PDO->prepare(
            "INSERT INTO session (
                session_ascii_id,
                logged_in,
                created,
                user_agent)
             VALUES (?, false, NOW(), ?)");
        $this->findActiveUserSessionStmt = self::$PDO->prepare(
            "SELECT * FROM session WHERE session_ascii_id = ?
			AND TIMESTAMPDIFF(SECOND,created,NOW()) < ?
			AND user_agent = ?
			AND ( TIMESTAMPDIFF(SECOND,last_reaction,NOW()) <= ?
            OR last_reaction = 0)"
        );
        $this->deleteInactiveUserSessionStmt = self::$PDO->prepare(
            "DELETE FROM session WHERE session_ascii_id = ?
            OR TIMESTAMPDIFF(SECOND,created,NOW()) > ?"
        );
        $this->updateLastReactionStmt = self::$PDO->prepare(
            "UPDATE session SET last_reaction = NOW()
            WHERE id = ?"
        );
    }

    protected function targetClass()
    {
        return "lab\domain\Session";
    }

    public function findBySessionAscii(\lab\domain\Session $obj)
    {
        $this->findBySessionAsciiStmt->execute(array($obj->getAsciiId()));
        $array = $this->findBySessionAsciiStmt->fetch(\PDO::FETCH_ASSOC);
        if(is_array($array)) {
            return $array;
        }
        false;
        //$obj);
    }

    public function isUserSessionActive(\lab\domain\Session $obj)
    {
        $array = array(
            $obj->getAsciiId(),
            $obj->getLifespan(),
            $obj->getUserAgent(),
            $obj->getTimeout()
        );
        $this->findActiveUserSessionStmt->execute($array);
        $array = $this->findActiveUserSessionStmt->fetch();
        if(is_array($array)) {
            return true;
        }
        return false;
    }

    public function deleteInactiveUserSession(\lab\domain\Session $obj)
    {
        $array = array($obj->getAsciiId(), $obj->getLifespan());
        $this->deleteInactiveUserSessionStmt->execute($array);
    }

    protected function doCreateObject(array $session)
    {

    }

    protected function doInsert(DomainObject $object)
    {
        $array = array($object->getAsciiId(), $object->getUserAgent());
        //print_r()
        $this->insertStmt->execute($array);
        print_r($this->insertStmt);
        return self::$PDO->lastInsertId();
    }

    public function update(DomainObject $object)
    {

    }

    public function selectStmt()
    {
        return $this->selectStmt;
    }
}
