<?php
namespace lab\domain;

class Session extends DomainObject
{
    private $asciiId = null;
    private $userAgent = null;
    private $userId;
    private $timeout = 600;		//10-minutowy maksymalny czas nieaktywności sesji
    private $lifespan = 3600;	// 1-godzinny maksymalny czas ważności sesji
    protected $loggedIn = false;

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

        parent::__construct();

        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
		if ($_COOKIE["PHPSESSID"]) {
            $this->asciiId = $_COOKIE["PHPSESSID"];
            echo $this->asciiId;
            $finder = self::getFinder();
			if (!$finder->isUserSessionActive($this)) {
				//Usuwa przeterminowanie sesje
			    $finder->deleteInactiveUserSession($this);
				/*Usuwa nieprzydatne zmienne sesji
				$result = $this->dbhandle->query("DELETE FROM session_variable
								  WHERE session_id NOT IN
				  				  (SELECT id FROM user_session)");
                */
				unset($_COOKIE["PHPSESSID"]);
			}
		}
		//Ustawienie czasu życia COOKIE
		session_set_cookie_params($this->lifespan);
		session_start();
    }

    public function getAsciiId()
    {
        return $this->asciiId;
    }

    public function getUserAgent()
    {
        return $this->userAgent;
    }

    public function getLoggedIn()
    {
        return $this->loggedIn;
    }

    public function getLifespan()
    {
        return $this->lifespan;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function Impress()
    {
        if ($this->id) {
            $stmt = "UPDATE session SET last_reaction = NOW() WHERE id = ".$this->native_session_id;
            $result = $this->dbhandle->query($stmt);
        }
    }
    private function sessionOpen ($save_path, $session_name)
    {
    	return true;
    }

    public function sessionClose ()
    {
	//	$this->dbhandle->close();
		return true;
	}

    public function sessionRead ($sessionAsciiId) {
		$this->asciiId = $sessionAsciiId;
echo 'Session::sessionRead echo: '.$this->asciiId;
		$failed = 1;
        $finder = self::getFinder();
        $array = $finder->findBySessionAscii($this);
		if ($array) {
			$this->id = $array['id'];
			if ($array['logged_in'] == true) {
				$this->loggedIn = true;
				$this->userId = $array['user_id'];
			}
		} else {
            $this->id = $finder->insert($this);
			//$result = $this->dbhandle->query($stmt);
			//$result = $this->dbhandle->query("SELECT id from session
			//								WHERE session_ascii_id = '".$id."'");
		//	$this->id = $row['id'];
		}
        echo '<pre>';
        print_r($this);
        echo '</pre>';
		return "";
	}

	public function sessionWrite ($id, $sess_data) {
		return true;
	}

	private function sessionDestroy ($id) {
		$result = $this->dbhandle->query("DELETE FROM session
										WHERE session_ascii_id = '".$id."'");
		return true;
	}

	private function sessionGc ($maxlifetime) {
		return true;
	}
}
