<?php
require "../vendor/autoload.php";

use lab\domain\UserAccount;

$nrOfIterations = $argv[1];
$account = new UserAccount();
for ($i = 1; $i <= $nrOfIterations; $i++) {
    $pass = $account->generateRandomPassword(30);
    echo $i.'. '.$pass."\n";
}
