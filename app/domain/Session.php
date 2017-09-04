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
		if (isset($_COOKIE["PHPSESSID"])) {
            $this->asciiId = $_COOKIE["PHPSESSID"];
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
    public function setLoggedIn($status)
    {
        $this->loggedIn = $status;
    }
    public function setUserId($userId = null)
    {
        $this->userId = $userId;
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

    public function login(\lab\domain\User $user)
    {
        $finder = self::getFinder();
        $finder->login($user, $this);
    }

    public function logout()
    {
        if ($this->getLoggedIn()) {
            $finder = self::getFinder();
            $finder->logout($this);
            session_unset();
            session_destroy();
            $this->setId(null);
            $this->setLoggedIn(false);
            $this->setUserId(null);
        }
        echo '<pre>';
        print_r($this);
        echo '</pre>';
    }

    public function impress()
    {
        if ($id = $this->getId()) {
            $finder = self::getFinder();
            $finder->updateLastReaction($id);
        }
    }

    public function sessionRead ($sessionAsciiId) {
		$this->asciiId = $sessionAsciiId;
//echo 'Session::sessionRead echo:SessionIdentifer -> '.$this->asciiId;
        $finder = self::getFinder();
		if (!$finder->findByAsciiId($this)) {
            $finder->insert($this);
		}
        echo '<pre>';
        print_r($this);
        echo '</pre>';
		return "";
	}

    public function setVariable($name, $value)
    {
        $finder->insertVariable($this->asciiId, $name, $value);
    }

    public function getVariable($name)
    {
        $value = $finder->findVariable($name);

        return $array
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

	public function sessionWrite ($id, $sess_data) {
		return true;
	}

	private function sessionDestroy ($asciiId) {
		$finder = self::getFinder();
        $finder->deleteSession($asciiId);
		return true;
	}

	private function sessionGc ($maxlifetime) {
		return true;
	}
}
