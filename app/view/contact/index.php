<script>
document.getElementsByClassName("feature").onclick = "location.href='?cmd=test'";
</script>
<?php if (isset($messageType)) { ?>
<div class="alert <?php echo $messageType?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?php echo $message;?>
</div>
<?php } ?>
<h4>Lista kontaktów</h4>
<a class="add" href="?cmd=contact-new">Nowy kontakt</a>
<table class="list_table">
    <tr>
        <th>Imię i nazwisko</th>
        <th>Email</th>
        <th>Telefon</th>
    </tr>
    <?php foreach ($contacts as $contact) {?>
    <tr>
        <td class="feature"
        onclick = "location.href='?cmd=contact-show&id=<?php echo $contact->getId()?>'">
            <?php echo $contact->getFirstName().' '.$contact->getLastName();?>
        </td>
        <td class="feature"
          onclick = "location.href='?cmd=contact-show&id=<?php echo $contact->getId()?>'">
             <?php echo $contact->getEmail();?>
        </td>
        <td class="feature"
          onclick = "location.href='?cmd=contact-show&id=<?php echo $contact->getId()?>'">
             <?php echo $contact->getPhone();?>
        </td>
        <td>
            <?php if (isset($buttons['contact-edit'])) {?>
            <a class="edit" href="?cmd=contact-edit&id=<?php echo $client->getId();?>">
                Edytuj
            </a>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
