<?php
require "vendor/autoload.php";
$appHelper = \lab\base\ApplicationHelper::instance();
$appHelper->init();
$id = $appHelper->getRequest()->getProperty('q');
//$id =1;
$contactColl = lab\domain\Client::getFinder()->find($id)->getContactPersons();
echo json_encode($contactColl->getArray());
?>
