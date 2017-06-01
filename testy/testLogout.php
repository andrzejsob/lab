<?php require_once "../vendor/autoload.php";

use lab\domain\Session;
use lab\mapper\SessionMapper;
use lab\mapper\UserMapper;

$session = new Session();
$session->impress();
$session->logout();
echo 'Wylogowano';
