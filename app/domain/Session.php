<?php
namespace lab\domain;

class Session extends DomainObject
{
    private $asciiId = null;
    private $userAgent = null;
    private $user = null;
    private $timeout = 3600;		//10-minutowy maksymalny czas nieaktywności sesji
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
			if (!$this->finder()->isUserSessionActive($this)) {
				//Usuwa przeterminowanie sesje
			    $this->finder()->deleteInactiveUserSession($this);
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
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getAsciiId()
    {
        return $this->asciiId;
    }

    public function getUserAgent()
    {
        return $this->userAgent;
    }

    public function isUserLoggedIn()
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
        $this->finder()->login($user, $this);
    }

    public function logout()
    {
        if ($this->getLoggedIn()) {
            $this->finder()->logout($this);
            session_unset();
            session_destroy();
            $this->setId(null);
            $this->setLoggedIn(false);
            $this->setUser(null);
        }
    }

    public function impress()
    {
        if ($id = $this->getId()) {
            $this->finder()->updateLastReaction($id);
        }
    }

    public function sessionRead ($sessionAsciiId) {
		$this->asciiId = $sessionAsciiId;
//echo 'Session::sessionRead echo:SessionIdentifer -> '.$this->asciiId;
		if (!$this->finder()->findByAsciiId($this)) {
            $this->finder()->insert($this);
		}
		return "";
	}

    public function setVariable($name, $value)
    {
        $this->finder()->insertVariable($this->getId(), $name, $value);
    }

    public function getVariable($name)
    {
        $array = $this->finder()->findVariable($this->getId(), $name);
        return $array;
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
		$this->finder()->deleteSession($asciiId);
		return true;
	}

	private function sessionGc ($maxlifetime) {
		return true;
	}
}
