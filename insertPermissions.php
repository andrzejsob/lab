<?php
require_once 'vendor/autoload.php';

use lab\domain\Permission;

$appHelper = lab\base\ApplicationHelper::instance();
$appHelper->init();


$perm[] = new Permission(null, 'client', 'Klienci');
$perm[] = new Permission(null, 'client-new', 'Klient - nowy');
$perm[] = new Permission(null, 'client-edit', 'Klient - edycja');
$perm[] = new Permission(null, 'contact', 'Kontakty');
$perm[] = new Permission(null, 'contact-new', 'Kontakt - nowy');
$perm[] = new Permission(null, 'contact-edit', 'Kontakt - edycja');
$perm[] = new Permission(null, 'order', 'Zlecenia');
$perm[] = new Permission(null, 'order-new', 'Zlecenie - nowe');
$perm[] = new Permission(null, 'order-edit', 'Zlecenie - edycja');
$perm[] = new Permission(null, 'method', 'Metody badawcze');
$perm[] = new Permission(null, 'method-new', 'Metoda badawcza - nowa');
$perm[] = new Permission(null, 'method-edit', 'Metoda badawcza - edycja');
$perm[] = new Permission(null, 'role', 'Konta i uprawnienia');
$perm[] = new Permission(null, 'role-new', 'Konto - nowe');
$perm[] = new Permission(null, 'role-edit', 'Konto - edycja');
$perm[] = new Permission(null, 'role-delete', 'Konto - usuwanie');
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
