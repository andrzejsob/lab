<?php
namespace lab\domain;

class Session
{
    private $SessioAsciiId = null;
    private $userAgentString = null;
    private $id;
    private $userId;
    private $sessionTimeout = 600;		//10-minutowy maksymalny czas nieaktywności sesji
    private $sessionLifespan = 3600;	// 1-godzinny maksymalny czas ważności sesji
    protected $loggedIin;

    public function __construct()
    {
        session_set_save_handler(
			array(&$this, 'sessionOpen'),
			array(&$this, 'sessionClose'),
			array(&$this, 'sessionRead'),
			array(&$this, 'sessionWrite'),
			array(&$this, 'sessionDestroy'),
			array(&$this, 'sessionGc')
		);

        $this->SessionAsciiId = $_COOKIE["PHPSESSID"];
        $this->userAgentString = $_SERVER["HTTP_USER_AGENT"];

		if ($this->SessionAsciiId) {
            $array = array(
                $this->sessionAsciiId,
                $this->sessionLifespan,
                $this->userAgentString,
                $this->sessionTimeout
            );
            $finder = self::getFinder();
			if (!$finder->isUserSessionActive($array)) {
				//Usuwa przeterminowanie sesje
				$array = array($this->sessionAsciiId, $this->sessionLifespan)
			    $finder->deleteInactiveUserSession($array);
				/*Usuwa nieprzydatne zmienne sesji
				$result = $this->dbhandle->query("DELETE FROM session_variable
								  WHERE session_id NOT IN
				  				  (SELECT id FROM user_session)");
                */
				unset($_COOKIE["PHPSESSID"]);
			}
		}
		//Ustawienie czasu życia COOKIE
		session_set_cookie_params($this->session_lifespan);
		session_start();
    }

    public function Impress()
    {
        if ($this->native_session_id) {
            $stmt = "UPDATE user_session SET last_reaction = NOW() WHERE id = ".$this->native_session_id;
            $result = $this->dbhandle->query($stmt);
        }
    }
    private function sessionOpen ($save_path, $session_name)
    {
    	return true;
    }

    public function sessionClose ()
    {
		$this->dbhandle->close();
		return true;
	}

    public function sessionRead ($sessionAsciiId) {
		$this->sessionAsciiId = $sessionAsciiId;
		$failed = 1;
        $finder = $this->getFinder();
        $finder->findBySessionAscii(array($this->sessionAsciiId));
		if ($result->num_rows) {
			$row = $result->fetch_assoc();
			$this->native_session_id = $row["id"];
			if ($row["logged_in"] == true) {
				$this->logged_in = true;
				$this->user_id = $row["user_id"];
			} else {
				$this->logged_in = false;
			}
		} else {
			$this->logged_in = false;
			$stmt = "INSERT INTO user_session (session_ascii_id, logged_in, created, user_agent) VALUES ('".$id."', false, NOW(), '".$strUserAgent."')";
			$result = $this->dbhandle->query($stmt);
			$result = $this->dbhandle->query("SELECT id from user_session
											WHERE session_ascii_id = '".$id."'");
			$row = $result->fetch_assoc();
			$this->native_session_id = $row["id"];
		}
		return "";
	}

	public function sessionWrite ($id, $sess_data) {
		return true;
	}

	private function sessionDestroy ($id) {
		$result = $this->dbhandle->query("DELETE FROM user_session
										WHERE session_ascii_id = '".$id."'");
		return true;
	}

	private function sessionGc ($maxlifetime) {
		return true;
	}
}
