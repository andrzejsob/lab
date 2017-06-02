<?php
require_once "../vendor/autoload.php";

use lab\domain\Session;
use lab\mapper\SessionMapper;
use lab\mapper\UserMapper;

\lab\base\ApplicationHelper::instance()->init();
if(!isset($_SERVER['REQUEST_METHOD'])) {
    $_SERVER['HTTP_USER_AGENT'] = 'console';
}
$session = new Session();
$session->impress();

$um = new UserMapper();
$user = $um->authenticate('andrew', 'gainward');
echo '<pre>';
print_r($user);
echo '</pre>';
if (!$user) {
    echo 'Błędne dane logowania';
} else {
    echo "Autoryzacja poprawna\n";
    $session->login($user);
}
echo "<a href='testLogout.php'>Wyloguj</a>";
