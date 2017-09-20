<?php
foreach ($contracts as $contract) {
        echo $contract->getSum().' zł <br>';
        echo $contract->getFoundSource();
}
?>
