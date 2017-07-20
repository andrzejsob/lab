<?php
require_once "vendor/autoload.php";

use lab\domain\Method;

$method = new Method(null, 'XPS', 'Spektroskopia Fotoelektronów');
echo $method->getId(),"\n";
echo $method->getAcronym()."\n";
echo $method->getName()."\n";

$m = lab\domain\HelperFactory::getCollection(Method::class);
$m->add(new Method(null, 'UPS', 'Ultraviolet Photoelectron Spectroscopy'));
$m->add(new Method(null, 'AFM', 'Atomic Force Microscopy'));

foreach ($m as $method) {
    $i = 1;
    echo $i.'. '.$method->getId(),"\n";
    echo $i.'. '.$method->getAcronym()."\n";
    echo $i.'. '.$method->getName()."\n";
    $i++;
}
