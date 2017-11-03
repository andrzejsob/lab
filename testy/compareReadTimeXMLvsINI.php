<?php
$loadxmltime = 0;
$loadinitime = 0;
for ($i = 1; $i < 2; $i++) {
$start = microtime(true);
//--------------
$xml = simplexml_load_file('lab.xml');
foreach($xml as $key => $value) {
    //echo $key.' => '.$value."\n";
    $array[$key] = trim($value);
}
//print_r($array);
//--------------
$loadxml = microtime(true);
$iniArray = parse_ini_file('lab.ini', true);
print_r($iniArray);
$loadini = microtime(true);

$loadxmltime += $loadxml - $start;
$loadinitime += $loadini - $loadxml;
}
echo 'XML -> '. $loadxmltime . "us\n";
echo 'INI -> '. $loadinitime . "us\n";
