<?php
require_once "../vendor/autoload.php";

$order = new \lab\domain\InternalOrder();
$order->setNr(1);
$order->setYear(2017);
$order->setAkr(false);
$order->setOrderDate('2017-01-02');
$order->setReceiveDate('2017-01-09');
$order->setNrOfAnalyzes(2);
$order->setSum(188.42);
$order->setFoundSource('BS-P-03-002-16-L-02');
$order->setLoadNr('N-LA-11/2017');
var_dump($order->getId());
//var_dump($order->getMethods());
$cp_mapper = new \lab\mapper\ContactPersonMapper();
$order->setContactPerson($cp_mapper->find(1));

$m_mapper = new \lab\mapper\MethodMapper();
$method = $m_mapper->find(6);
$order->addMethod($method);
echo $order->getContactPerson()->getFirstName()." ";
echo $order->getContactPerson()->getLastName()."\n";
foreach ($order->getMethods() as $method) {
    echo $method->getAcronym()."\n";
}

$io_mapper = new \lab\mapper\InternalOrderMapper();
$io_mapper->insert($order);
echo 'Dodano zlecenie nr: '. $order->getCode();
