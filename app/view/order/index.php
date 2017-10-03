<script>
document.getElementsByClassName("feature").onclick = "location.href='?cmd=test'";
</script>
<?php if (isset($messageType)) { ?>
<div class="alert <?php echo $messageType?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?php echo $message;?>
</div>
<?php } ?>
<h4>Lista zleceń</h4>
<a class="add" href="?cmd=order-new">Nowe zlecenie</a>
<table class="list_table">
    <tr>
        <th>Kod</th>
        <th>Kontakt</th>
    </tr>
    <?php foreach ($orders as $order) {?>
    <tr>
        <td class="feature"
        onclick = "location.href='?cmd=order-show&id=<?php echo $order->getId()?>'">
            <?php echo $order->getCode()?>
        </td>
        <td class="feature"
        onclick = "location.href='?cmd=contact-show&id=
        <?php echo $order->getContactPerson()->getId()?>'">
            <?php echo $order->getContactPerson()->getFirstName().' '.
            $order->getContactPerson()->getLastName()?>
        </td>
        <td>
            <a class="delete" href="?cmd=order-delete&id=<?php echo $order->getId();?>">
                Usuń
            </a>
            <a class="edit" href="?cmd=order-edit&id=<?php echo $order->getId();?>">
                Edytuj
            </a>
        </td>
    </tr>
    <?php } ?>
</table>
