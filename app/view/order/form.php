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
               document.getElementById("clientSelect").innerHTML = text;
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
<select name="clientId" onchange="load(this.value)">
    <option style="display:none" disabled selected value>
        -- Wybierz klienta --
    </option>
    <?php foreach($clients as $client) { echo 'test';?>
    <option value="<?php echo $client->getId();?>" >
        <?php echo $client->getName();?>
    </option>
    <?php } ?>
</select>
<form method="post">
<h4>Osoba do kontaktu</h4>
<select id="clientSelect" name="contactId">
    <option disabled selected value>
        -- Nie wybrano klienta --
    </option>
</select>
<h5>Dane zlecenia</h5>
<table>
    <tr>
        <td>Data na zleceniu</td>
        <td><input type="text" name="orderDate" <?php echo 'value="'.
        $entity->getOrderDate().'"';?>>
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
</table>
<h5>Metody badawcze</h5>
<?php foreach ($methods as $method) {?>
<input type="checkbox" name="method[]"
    value="<?php echo $method->getId();?>"
>
<?php echo $method->getAcronym().'<br>';
}?><br>
<input type="submit" name="save" value="Zapisz">
</form>
