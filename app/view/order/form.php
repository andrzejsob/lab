<script>
function load(value) {
    var xmlhttp = new XMLHttpRequest();
       xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
             var obj = JSON.parse(this.responseText);
             var text = '';
             for (x in obj) {
               text += '<option value="' + obj[x].id + '">' + obj[x].first_name +
               ' ' + obj[x].last_name + '</option>';
             }
               document.getElementById("contactSelect").innerHTML = text;
           }
       };
       xmlhttp.open("GET", "test.php?q=" + value, true);
       xmlhttp.send();
}
</script>
<?php foreach ($errors as $key => $value) {
    echo '<p style="color: red">'.$value.'</p>';
} ?>
<h4>Klient</h4>
<form method="post">
<select name="clientId" onchange="load(this.value)">
    <option style="display:none" disabled selected value>
        -- Wybierz klienta --
    </option>
    <?php foreach($clients as $client) {?>
    <option value="<?php echo $client->getId();?>"
    <?php if ($client->getId() == $selectedClient->getId()) {
          echo 'selected';
    }?>>
    <?php echo $client->getName();?>
    </option>
    <?php } ?>
</select>

<h4>Osoba do kontaktu</h4>
<select id="contactSelect" name="contactId">
    <?php if ($selectedContact->getId()) {
        foreach ($selectedClientContacts as $contact) {?>
          <option value="<?php echo $contact->getId();?>"
          <?php if ($selectedContact->getId() == $contact->getId()) {?>
                selected
          <?php } ?>>
          <?php echo $contact->getFirstName().' '.$contact->getLastName()?>
          </option>
  <?php }
    } else {?>
    <option disabled selected value>
        -- Nie wybrano klienta --
    </option>
    <?php }?>
</select>
<h5>Dane zlecenia</h5>
<table>
    <tr>
        <td>Data na zleceniu</td>
        <td><input type="text" name="orderDate" <?php echo 'value="'.
        $entity->getOrderDate().'"';?>>
        </td>
    </tr>
    <tr>
        <td>Data wpływu zlecenia</td>
        <td><input type="text" name="receiveDate" <?php echo 'value="'.
        $entity->getReceiveDate().'"';?>>
    </tr>
    <tr>
        <td>Liczba analiz</td>
        <td><input type="text" name="nrOfAnalyzes" <?php echo 'value="'.
        $entity->getNrOfAnalyzes().'"';?>>
    </tr>
    <tr>
        <td>Kwota</td>
        <td><input type="text" name="sum" <?php echo 'value="'.
        $entity->getSum().'"';?>>
    </tr>
    <tr>
        <td>Źródło finansowania</td>
        <td><input type="text" name="foundSource" <?php echo 'value="'.
        $entity->getFoundSource().'"';?>>
    </tr>
    <tr>
        <td>Nr obciążenia</td>
        <td><input type="text" name="loadNr" <?php echo 'value="'.
        $entity->getLoadNr().'"';?>>
    </tr>
    <tr>
        <td>AKR</td>
        <td><input type="checkbox" name="akr" value=1
        <?php if ($entity->getAkr()) {?>
            checked
        <?php } ?>>
        </td>
    </tr>
</table>
<h5>Metody badawcze</h5>
<?php foreach ($methods as $method) {?>
<input type="checkbox" name="methods[]"
    value="<?php echo $method->getId()?>"
    <?php if (in_array($method->getId(), $checkedMethodsIdArray)) {?>
    checked
    <?php }?>
>
<?php echo $method->getAcronym().'<br>';
}?><br>
<input type="submit" name="save" value="Zapisz">
</form>
