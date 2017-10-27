<?php echo $contact->getFirstName().' '.$contact->getLastName();?><br />
<?php echo $contact->getEmail();?><br />
<?php echo $contact->getPhone();?>
<h5>Zlecenia</h5>
<?php if ($orders->valid()) {?>
    <table class="list_table">
        <tr>
            <th>Kod</th>
            <th>Data na zleceniu</th>
            <th>Data wpływu zlecenia</th>
            <th>Liczba analiz</th>
        </tr>
        <?php foreach ($orders as $order) {?>
        <tr>
            <td class="feature"
            onclick = "location.href='?cmd=order-show&id=<?php echo $order->getId()?>'">
                <?php echo $order->getCode()?>
            </td>
            <td class="feature">
                <?php echo $order->getOrderDate()?>
            </td>
            <td class="feature">
                <?php echo $order->getReceiveDate()?>
            </td>
            <td class="feature">
                <?php echo $order->getNrOfAnalyzes()?>
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
<?php } else { ?>
    <p style="color:red;">Brak zleceń klienta na twoje techniki badawcze.</p>
<?php } ?>
