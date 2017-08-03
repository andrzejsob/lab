<?php
require_once "../vendor/autoload.php";

use lab\validation\Facade;
use lab\controller\Request;
use lab\base\ApplicationHelper;

$_SERVER['HTTP_USER_AGENT'] = 'console';

$request = ApplicationHelper::getRequest();

$validation = new Facade();
$validation->addNumericValidation('liczba', 'Liczba nie jest liczba');
$validation->addNoEmptyValidation('nazwa', 'Nazwa nie może być pusta');
$validation->addAlnumValidation('nazwa', 'Nazwa to tylko symbole alfanum.');
$validation->validate($request);
$isValid = $validation->isValid();
var_dump($isValid);
var_dump($request->getProperty('nazwa'));
print_r($validation->getErrors());
