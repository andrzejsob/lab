<?php
require "vendor/autoload.php";

use lab\domain\User;
use lab\mapper\UserMapper;

$id = $argv[1];

$start = microtime(true);
$u_mapper = new UserMapper();
$user = $u_mapper->find($id);

$io_mapper = new \lab\mapper\InternalOrderMapper();
$orders = $io_mapper->selectByMethods($user->getMethods());

foreach ($orders as $o) {
//    $o->getContactPerson();
//    $o->getMethods();
    print_r($o);
}

echo microtime(true) - $start;
?>
