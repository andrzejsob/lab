<?php
require_once "vendor/autoload.php";

use lab\mapper\UserMapper;

$u_mapper = new UserMapper();
$users = $u_mapper->findAll();

foreach($users as $user) {
    print_r($user);
}
