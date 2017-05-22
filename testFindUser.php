<?php
require "vendor/autoload.php";

use lab\domain\User;
use lab\mapper\UserMapper;

$id = $argv[1];

$u_mapper = new UserMapper();
$user = $u_mapper->find($id);

//print_r($user);

$methods = $user->getMethods();
foreach($methods as $method) {
    print_r($method);
}
