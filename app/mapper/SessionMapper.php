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
                session_asci_id,
                logged_id,
                created,
                user_agent)
             VALUES (?, false, NOW(), ?)");
        $this->findActiveUserSessionStmt = self::$PDO->prepare(
            "SELECT id FROM user_session WHERE session_ascii_id = ?
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
            WHERE id = ?";
        );
    }

    protected function targetClass()
    {
        return "lab\domain\Session";
    }

    public function findBySessionAscii($array)
    {
        $this->findBySessionAsciiStmt->execute($array);
        $array = $this->findBySessionAsciiStmt->fetch();
        if(!is_array($array)) {
            return false;
        }
        return $array;
    }

    public function isUserSessionActive($array)
    {
        $this->findActiveUserSessionStmt->execute($array);
        $session = $this->findActiveUserSessionStmt->fetch();
        if($session['id']) {
            return true;
        }
        return false;
    }

    public function deleteInactiveUserSession($array)
    {
        $this->deleteInactiveUserSessionStmt->execute($array);
    }

    protected function doCreateObject(array $session)
    {

    }

    protected function doInsert(DomainObject $object)
    {

    }

    public function update(DomainObject $object)
    {

    }

    public function selectStmt()
    {
        return $this->selectStmt;
    }
}
