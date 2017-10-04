<?php
require_once 'vendor/autoload.php';

use lab\domain\Permission;

$appHelper = lab\base\ApplicationHelper::instance();
$appHelper->init();

$perm[] = new Permission(null, 'user', 'Użytkownicy');
$perm[] = new Permission(null, 'user-edit', 'Użytkownik - edycja');
$perm[] = new Permission(null, 'user-new', 'Użytkownik - nowy');
$perm[] = new Permission(null, 'user-delete', 'Użytkownik - usuwanie');

foreach ($perm as $p) {
    $p->save();
}
$permColl = Permission::getFinder()->findAll();
echo "id name description\n";
foreach ($permColl as $perm) {
    echo $perm->getId().' '.$perm->getName().' '.$perm->getDescription()."\n";
}
