<?php
require_once "vendor/autoload.php";

$m_mapper = new lab\mapper\MethodMapper();
$mm_collection = $m_mapper->findAll();

foreach($mm_collection as $method) {
    print_r($method);
}
