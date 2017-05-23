<?php
require_once 'vendor/autoload.php';

$client_id = $argv[1];
$imie = $argv[2];
$nazwisko = $argv[3];

$client_mapper = new \lab\mapper\ClientMapper();
//$client = $client_mapper->find($client_id);
/*
if (is_null($client)) {
    echo 'Nie znaleziono klienta o id = '.$client_id;exit;
}
*/
//pusty klient
$client = new \lab\domain\Client();

$cperson = new \lab\domain\ContactPerson();
$cperson->setFirstName($imie);
$cperson->setLastName($nazwisko);
$cperson->setClient($client);

$cp_mapper = new \lab\mapper\ContactPersonMapper();
$cp_mapper->insert($cperson);

//print_r($cperson);
