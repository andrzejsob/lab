<?php
require "vendor/autoload.php";

use lab\domain\User;
use lab\mapper\UserMapper;

$id = $argv[1];

$start = microtime(true);
$u_mapper = new UserMapper();
$user = $u_mapper->find($id);
$methods = $user->getMethods();

$io_mapper = new \lab\mapper\InternalOrderMapper();
$orders = $io_mapper->selectByMethods($methods);

foreach ($orders as $o) {
//    $o->getContactPerson();
//    $o->getMethods();
    print_r($o);
}

echo microtime(true) - $start;
?>
