<script>
document.getElementsByClassName("feature").onclick = "location.href='?cmd=test'";
</script>
<?php if (isset($messageType)) { ?>
<div class="alert <?php echo $messageType?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?php echo $message;?>
</div>
<?php } ?>
<h4>Lista klientów</h4>
<a class="add" href="?cmd=client-form">Nowy klient</a>
<table class="list_table">
    <tr>
        <th>Nazwa</th>
        <th>Miasto</th>
    </tr>
    <?php foreach ($clients as $client) {?>
    <tr>
        <td class="feature"
        onclick = "location.href='?cmd=client-show&id=<?php echo $client->getId()?>'">
            <?php echo $client->getName();?></td>
        <td class="feature"
        onclick = "location.href='?cmd=client-show&id=<?php echo $client->getId()?>'">
            <?php echo $client->getCity();?></td>
        <td>
            <?php if (isset($buttons['client-delete'])) {?>
            <a class="delete" href="?cmd=client-delete&id=<?php echo $client->getId();?>">
                Usuń
            </a>
            <?php } ?>
            <?php if (isset($buttons['client-new'])) {?>
            <a class="edit" href="?cmd=client-edit&id=<?php echo $client->getId();?>">
                Edytuj
            </a>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
