<?php
require_once 'vendor/autoload.php';

use lab\domain\Permission;

$appHelper = lab\base\ApplicationHelper::instance();
$appHelper->init();
$perm = Permission::getFinder()->find(7);
$perm->setDescription('Uźytkownicy');
//$perm = new Permission(null, 'role-form', 'Dodawanie i edytowanie kont');
print_r($perm);
$perm->save();
