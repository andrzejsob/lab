<?php
require "vendor/autoload.php";

use lab\domain\User;
use lab\mapper\UserMapper;

$id = $argv[1];

$u_mapper = new UserMapper();
$user = $u_mapper->find($id);

echo $user->getFirstName()." ".$user->getLastName()."\n";

$methods = $user->getMethods();
foreach($methods as $method) {
    print_r($method);
}
