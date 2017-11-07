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
        <th>Data na zleceniu</th>
        <th>Data wpływu</th>
        <th>Liczba analiz</th>
        <th>Kwota [zł]</th>
        <th>ZFin</th>
        <th>Nr obciążenia</th>
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
        <td class="feature"
        onclick = "location.href='?cmd=order-show&id=<?php echo $order->getId()?>'">
            <?php echo $order->getOrderDate()?>
        </td>
        <td class="feature"
        onclick = "location.href='?cmd=order-show&id=<?php echo $order->getId()?>'">
            <?php echo $order->getReceiveDate()?>
        </td>
        <td class="feature"
        onclick = "location.href='?cmd=order-show&id=<?php echo $order->getId()?>'">
            <?php echo $order->getNrOfAnalyzes()?>
        </td>
        <td class="feature"
        onclick = "location.href='?cmd=order-show&id=<?php echo $order->getId()?>'">
            <?php echo $order->getSum()?>
        </td>
        <td class="feature"
        onclick = "location.href='?cmd=order-show&id=<?php echo $order->getId()?>'">
            <?php echo $order->getFoundSource()?>
        </td>
        <td class="feature"
        onclick = "location.href='?cmd=order-show&id=<?php echo $order->getId()?>'">
            <?php echo $order->getLoadNr()?>
        </td>
        <td>
            <?php if (isset($buttons['order-edit'])) {?>
            <a class="edit" href="?cmd=order-edit&id=<?php echo $order->getId();?>">
                Edytuj
            </a>
            <?php }?>
        </td>
    </tr>
    <?php } ?>
</table>
