<?php
require_once 'vendor/autoload.php';

use lab\domain\Permission;

$appHelper = lab\base\ApplicationHelper::instance();
$appHelper->init();
$perm = new Permission(null, 'iorder', 'Zlecenia');
$perm2 = new Permission(null, 'iorder-form', 'Dodawanie/edycja zleceń');
//$perm = new Permission(null, 'role-form', 'Dodawanie i edytowanie kont');
print_r($perm);
$perm->save();
$perm2->save();
