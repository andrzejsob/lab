<?php foreach($clients as $client) { ?>
    <a href="?cmd=client-show?id=<?php echo $client->getId();?>">
        <?php echo $client->getName(); ?>
    </a>
    <br>
<?php } ?>
