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
<p id="txtHint"></p>
<h4>Klient</h4>
<select name="clientId" onchange="load(this.value)">
    <option style="display:none" disabled selected value>
        -- Wybierz klienta --
    </option>
    <?php foreach($clients as $client) {?>
    <option value="<?php echo $client->getId();?>" >
        <?php echo $client->getName();?>
    </option>
    <?php } ?>
</select>
<h4>Kontakt</h4>
<select id="clientSelect" name="contactId">
    <?php foreach($contacts as $contact) {?>
    <option value="<?php echo $contact->getId();?>">
        <?php echo $contact->getFirstName().' '.$contact->getLastName();?>
    </option>
    <?php } ?>
</select>
<p id='hint'></p>
