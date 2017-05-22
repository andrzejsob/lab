<?php
require_once 'vendor/autoload.php';

$name = $argv[1];

$client = new \lab\domain\Client();
$client->setName($name);

$client_mapper = new lab\mapper\ClientMapper();
$client_mapper->insert($client);

print($client->getId());
