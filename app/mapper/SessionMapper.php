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
            'SELECT * FROM session');
        $this->findByAsciiIdStmt = self::$PDO->prepare(
            "SELECT * FROM session WHERE session_ascii_id = ?");
        $this->insertStmt = self::$PDO->prepare(
            "INSERT INTO session (
            session_ascii_id,
            logged_in,
            created,
            user_agent)
            VALUES (?, false, NOW(), ?)"
         );
        $this->findActiveUserSessionStmt = self::$PDO->prepare(
            "SELECT * FROM session WHERE session_ascii_id = ?
			AND TIMESTAMPDIFF(SECOND,created,NOW()) < ?
			AND user_agent = ?
			AND ( TIMESTAMPDIFF(SECOND,last_reaction,NOW()) <= ?
            OR last_reaction = 0)"
        );
        $this->deleteSessionStmt = self::$PDO->prepare(
            "DELETE FROM session WHERE session_ascii_id = ?"
        );

        $this->deleteInactiveUserSessionStmt = self::$PDO->prepare(
            "DELETE FROM session WHERE session_ascii_id = ?
            OR TIMESTAMPDIFF(SECOND,created,NOW()) > ?
            OR TIMESTAMPDIFF(SECOND, last_reaction, NOW()) > ?"
        );
        $this->updateLastReactionStmt = self::$PDO->prepare(
            "UPDATE session SET last_reaction = NOW()
            WHERE id = ?"
        );
        $this->loginUserStmt = self::$PDO->prepare(
            "UPDATE session SET logged_in = true, user_id = ? WHERE id = ?"
        );
        $this->logoutUserStmt = self::$PDO->prepare(
            "UPDATE session SET logged_in = false, user_id = null WHERE id = ?"
        );
    }

    protected function targetClass()
    {
        return "lab\domain\Session";
    }

    public function findByAsciiId(\lab\domain\Session $obj)
    {
        $this->findByAsciiIdStmt->execute(array($obj->getAsciiId()));
        $array = $this->findByAsciiIdStmt->fetch(\PDO::FETCH_ASSOC);
        if(is_array($array)) {
            $obj->setId($array['id']);
            $obj->setloggedIn($array['logged_in']);
            $obj->setUserId($array['user_id']);
            return true;
        }
        return false;
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
        $array = array(
            $obj->getAsciiId(),
            $obj->getLifespan(),
            $obj->getTimeout()
        );
        $this->deleteInactiveUserSessionStmt->execute($array);
    }

    protected function doCreateObject(array $session)
    {

    }

    protected function doInsert(DomainObject $object)
    {
        $array = array($object->getAsciiId(), $object->getUserAgent());
        $this->insertStmt->execute($array);
        $object->setId(self::$PDO->lastInsertId());
    }

    public function updateLastReaction($id)
    {
        $this->updateLastReactionStmt->execute(array($id));
    }
    public function update(DomainObject $object)
    {

    }
    public function login($user, $session)
    {
        $array = array($user->getId(), $session->getId());
        $this->loginUserStmt->execute($array);
        $session->setLoggedIn(true);
        $session->setUserId($user->getId());
    }

    public function logout($session)
    {
        $array = array($session->getAsciiId());
        $this->logoutUserStmt->execute($array);

    }

    public function deleteSession($asciiId)
    {
        $this->deleteSessionStmt->execute(array($asciiId));
    }

    public function selectStmt()
    {
        return $this->selectStmt;
    }
}
