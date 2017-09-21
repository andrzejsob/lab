<?php
require "vendor/autoload.php";
$id = $_REQUEST['q'];
$appHelper = \lab\base\ApplicationHelper::instance();
$appHelper->init();

$contactColl = lab\domain\Client::getFinder()->find($id)->getContactPersons();
$array = array();
foreach($contactColl as $contact) {
    $array = json_parse($contact);
}
echo json_parse($array);
