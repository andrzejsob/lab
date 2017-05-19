<?php
require_once "vendor/autoload.php";

use lab\domain\Method;
use lab\mapper\MethodMapper;

$skrot = $argv[1];
$nazwa = $argv[2];

$method = new Method(null, $skrot, $nazwa);
$m_mapper = new MethodMapper();
if (is_null($method->getAcronym()) || is_null($method->getName())) {
    echo 'Brak skrotu/nazwy!';exit(1);
}
$m_mapper->insert($method);
echo "Dodano wiersz nr: ".$method->getId(),"\n";
