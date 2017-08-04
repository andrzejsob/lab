<?php
require_once "../vendor/autoload.php";

use lab\validation\Facade;
use lab\controller\Request;
use lab\base\ApplicationHelper;

$_SERVER['HTTP_USER_AGENT'] = 'console';

$request = ApplicationHelper::getRequest();

$validation = new Facade();
$validation->addNumericValidation('liczba', 'Liczba nie jest liczba');
$validation->addZipCodeValidation('zip_code', 'Błędny format kodu pocztowego');
$validation->validate($request);
$isValid = $validation->isValid();
var_dump($isValid);
var_dump($request->getProperty('zip_code'));
var_dump($request->getProperty('nazwa'));
print_r($validation->getErrors());
var_dump(preg_match('/^\d{2}-{3}$/', $request->getProperty('zip_code')));
