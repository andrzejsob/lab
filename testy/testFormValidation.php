<?php
require_once "../vendor/autoload.php";

use lab\validation\Facade;
use lab\controller\Request;

$_SERVER['HTTP_USER_AGENT'] = 'console';

$request = new Request();

$validation = new Facade();
$validation->addNumericValidation('liczba', 'Liczba nie jest liczba');
$validation->addAlnumValidation('tekst', 'To nie jest tekst');
$validation->validate($request);
//var_dump($validation);
print_r($validation->getErrors());
