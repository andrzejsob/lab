<?php
require_once '../vendor/autoload.php';

$akr = $argv[1];

$order = new \lab\domain\InternalOrder();
$order->setNr(102);
$order->setYear(2017);
$order->setAkr($akr);

echo $order->getCode();
