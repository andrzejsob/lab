<?php
namespace lab\base;

class ApplicationHelper
{
    private static $instance = null;
    private $request = null;
    private $session = null;
	private $map = null;
    private $appcontroller = null;
    private $iniFilePath = __DIR__ . "/../../../lab.ini";
    private $values = array();

    private function __construct() {}

    public static function instance()
    {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init()
    {
        $this->ensure(file_exists($this->iniFilePath), 'Brak pliku ini');
        $array = parse_ini_file($this->iniFilePath, true);
        foreach ($array as $key => $value) {
            $this->values[$key] = $value;
        }
    }

    private function ensure($expr, $message)
    {
        if (!$expr) {
            throw new \Exception($message);
        }
    }

    protected function set($key, $val)
    {

    }

    static function getDSN()
    {
        return self::instance()->values['database'];
    }

    static public function getMail()
    {
        return self::instance()->values['mail'];
    }

    static function setDSN($dsn)
    {
        return self::instance()->set('dsn', $dsn);
    }

    static function getRequest()
    {
        $inst = self::instance();
        if(is_null($inst->request)) {
            $inst->request = new \lab\controller\Request();
        }
        return $inst->request;
    }

    static function getSession()
    {
        $inst = self::instance();
        if(is_null($inst->session)) {
            $inst->session = new \lab\domain\Session();
        }
        return $inst->session;
    }

    static function getSessionMessage()
    {
        $session = self::getSession();
        $array = $session->getVariable('message');
        if($array) {
            list($message_type, $message) = explode('_', $array['value']);
            return array(
                'messageType' => $message_type,
                'message' => $message
            );
        }
        return array();
    }

	static function setControllerMap($map)
	{
		$inst = self::instance();
		if(is_null($inst->map)) {
            $inst->map = $map;
        }
	}

    static function appController()
    {
        $inst = self::instance();
        if (is_null($inst->appcontroller)) {
            $inst->appcontroller = new \woo\controller\AppController($inst->map);
        }
        return $inst->appcontroller;
    }
}
