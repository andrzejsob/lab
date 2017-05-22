<?php
require_once "vendor/autoload.php";

use lab\mapper\UserMapper;
use lab\domain\User;

$user = new User(
    null,
    'andrew',
    md5('gainward'),
    'Andrzej',
    'Sobieszek',
    'andreeww2@gmail.com'
);

$u_mapper = new UserMapper();
$u_mapper->insert($user);
