<?php

class UserSession {
	private $php_session_id;
	private $native_session_id;
	protected $dbhandle;
	protected $logged_in;
	private $user_id;
	private $session_timeout = 600;		//10-minutowy maksymalny czas nieaktywności sesji
	private $session_lifespan = 3600;	// 1-godzinny maksymalny czas ważności sesji

	public function __construct () {
		$this->dbhandle = new mysqli('localhost', 'root', 'gainward', 'lab');
		// Check connection
		if ($this->dbhandle->connect_error) {
			die("Connection failed: " . $this->dbhandle->connect_error);
		}

		session_set_save_handler (
			array(&$this, '_session_open_method'),
			array(&$this, '_session_close_method'),
			array(&$this, '_session_read_method'),
			array(&$this, '_session_write_method'),
			array(&$this, '_session_destroy_method'),
			array(&$this, '_session_gc_method')
		);

		$strUserAgent = $_SERVER["HTTP_USER_AGENT"];
		if (isset($_COOKIE["PHPSESSID"])) {
			$this->php_session_id = $_COOKIE["PHPSESSID"];
			$stmt = "SELECT id FROM user_session WHERE session_ascii_id = '".$this->php_session_id."'
					AND TIMESTAMPDIFF(SECOND,created,NOW()) < ".$this->session_lifespan."
					AND user_agent = '".$strUserAgent."'
					AND ( TIMESTAMPDIFF(SECOND,last_reaction,NOW()) <= ".$this->session_timeout." OR last_reaction = 0)";
			$result = $this->dbhandle->query($stmt);
			if ($result->num_rows == 0) {
				//Ustawienie znacznika niepowodzenia
				$failed = 1;
				//Usuwa przeterminowanie sesje
				$result = $this->dbhandle->query("DELETE FROM user_session WHERE session_ascii_id = '".$this->php_session_id."'
												  OR TIMESTAMPDIFF(SECOND,created,NOW()) > ".$this->session_lifespan);
				//Usuwa nieprzydatne zmienne sesji
				$result = $this->dbhandle->query("DELETE FROM session_variable
								  WHERE session_id NOT IN
				  				  (SELECT id FROM user_session)");
				unset($_COOKIE["PHPSESSID"]);
			}
		}
		//Ustawienie czasu życia COOKIE
		session_set_cookie_params($this->session_lifespan);
		session_start();
	}

	public function Impress () {
		if ($this->native_session_id) {
			$stmt = "UPDATE user_session SET last_reaction = NOW() WHERE id = ".$this->native_session_id;
			$result = $this->dbhandle->query($stmt);
		}
	}

	public function IsLoggedIn () {
		return $this->logged_in;
	}

	public function getUserId () {
		if ($this->logged_in) return $this->user_id;
		return false;
	}

	public function GetUserObject () {
		if ($this->logged_in) {
			if (class_exists("user")) return new User($this->user_id);
			return false;
		}
	}

	//zwara true jeżeli nazwa uzytkownika jest wolna
	public function checkIfUserLoginNameIsFree($name) {
		$stmt = "SELECT id from user WHERE user_name = '".$name."'";
		$result = $this->dbhandle->query($stmt);
		if ($result->num_rows) {
			return false;
		} else {
			return true;
		}
	}

	public function isEmail($email) {
		$stmt = "SELECT id from user WHERE email = '".$email."'";
		$result = $this->dbhandle->query($stmt);
		if ($result->num_rows) {
			return true;
		} else {
			return false;
		}
	}

	public function updatePassword($email, $md5_password) {
		$stmt = "UPDATE user SET password_md5 = '".$md5_password."' WHERE email = '".$email."'";
		$result = $this->dbhandle->query($stmt);
	}

	public function registerUser ($user_name, $password, $firstname, $lastname) {
		$stmt = "UPDATE user SET user_name = '".$user_name."', password_md5 = '".md5($password)."'
		WHERE firstname = '".$firstname."' AND lastname = '".$lastname."'";
		$result = $this->dbhandle->query($stmt);
		if ($result->num_rows) {
			return true;
		} else {
			return false;
		}
	}

	public function userFullNameIsCorrect($firstname, $lastname) {
		$stmt = "SELECT id from user WHERE firstname = '".$firstname."' AND lastname = '".$lastname."'";
		$result = $this->dbhandle->query($stmt);
		if ($result->num_rows) {
			return true;
		} else {
			return false;
		}
	}

	public function GetSessionIdentifier () {
		return $this->php_session_id;
	}

	public function Login ($strUsername, $strPlainPassword) {
		$strMD5Password = md5($strPlainPassword);
		$stmt = "SELECT id FROM user
				WHERE user_name = '".$strUsername."'
				AND password_md5 = '".$strMD5Password."'";
				//echo $stmt; exit;
		$result = $this->dbhandle->query($stmt);
		if ($result->num_rows) {
			$row = $result->fetch_assoc();
			$this->user_id = $row["id"];
			$this->logged_in = true;
			$stmt = "UPDATE user_session SET logged_in = true, user_id = ".$this->user_id."
											WHERE id = ".$this->native_session_id;
			$result = $this->dbhandle->query($stmt);
			return true;
		} else {
			return false;
		}
	}

	public function LogOut () {
		if ($this->logged_in == true) {
			$result = $this->dbhandle->query("UPDATE user_session SET logged_in = false, user_id = null
											WHERE id = '".$this->native_session_id."'");
			$this->logged_in = false;
			$this->user_id = 0;
			session_unset();
			session_destroy();
			return true;
		} else {
			return false;
		}
	}

	public function __get ($nm) {
		$result = $this->dbhandle->query("SELECT value FROM session_variable
										WHERE session_id = ".$this->native_session_id."
										AND name = '".$nm."'");
		if ($result->num_rows) {
			$row = $result->fetch_assoc();
			return unserialize($row["value"]);
		} else {
			return false;
		}
	}

	public function __set ($nm, $val) {
		$strSer = serialize($val);
		$stmt = "INSERT INTO session_variable (session_id, name, value)
				VALUES (".$this->native_session_id.", '".$nm."', '".$strSer."')";
		$result = $this->dbhandle->query($stmt);
	}

	public function delete_session_variable ($nm)
	{
		if($this->message)
		{
	        $stmt = "DELETE FROM session_variable WHERE name = '".$nm."'
		             AND session_id = ".$this->native_session_id;
		    $result = $this->dbhandle->query($stmt);
		}
	}

	public function delete_all_session_variables ()
	{
	    $stmt = "DELETE FROM session_variable WHERE session_id = ".$this->native_session_id;
		$result = $this->dbhandle->query($stmt);
	}

	private function _session_open_method ($save_path, $session_name) {
		return true;
	}

	public function _session_close_method () {
		$this->dbhandle->close();
		return true;
	}

	public function _session_read_method ($id) {
		$strUserAgent = $_SERVER['HTTP_USER_AGENT'];
		$this->php_session_id = $id;
		$failed = 1;
		$result = $this->dbhandle->query("SELECT id, logged_in, user_id FROM user_session WHERE session_ascii_id = '".$id."'");
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

	public function _session_write_method ($id, $sess_data) {
		return true;
	}

	private function _session_destroy_method ($id) {
		$result = $this->dbhandle->query("DELETE FROM user_session
										WHERE session_ascii_id = '".$id."'");
		return true;
	}

	private function _session_gc_method ($maxlifetime) {
		return true;
	}
}
?>
