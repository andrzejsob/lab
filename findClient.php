<?php
require "vendor/autoload.php";

use lab\domain\User;
use lab\mapper\ClientMapper;

$id = $argv[1];

$mapper = new ClientMapper();
$client = $mapper->find($id);

echo $client->getName();
print_r($client);
