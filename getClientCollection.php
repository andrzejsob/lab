<?php
require_once 'vendor/autoload.php';

$client_mapper = new \lab\mapper\ClientMapper();
$cc = $client_mapper->findAll();

//echo $client->getName();
foreach($cc as $client) {
    print_r($client);
}
