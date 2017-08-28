<?php
require_once 'vendor/autoload.php';

//$name = $argv[1];

$client = new \lab\domain\Client();
$client->setName('andrew');

$client2 = $client;
$client2->setName('jack');

echo '<pre>';
print_r($client);
print_r($client2);
echo '</pre>';
//$client_mapper = new lab\mapper\ClientMapper();
//$client_mapper->insert($client);

print($client->getId());
