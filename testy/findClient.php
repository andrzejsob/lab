<?php
require "../vendor/autoload.php";

use lab\domain\User;
use \lab\mapper\ClientMapper;

$id = $argv[1];

$mapper = new ClientMapper();
$client = $mapper->find($id);

echo $client->getName()."\n";
//print_r($client);

$persons = $client->getContactPersons();

foreach ($persons as $person) {
    print_r($person);
}
