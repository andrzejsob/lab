<h3>Nowy klient</h3>
<?php
if (isset($errors)) {
    foreach ($errors as $key => $value) {
        echo '<p style="color: red">'.$value.'</p>';
    }
}
?>
<form method="post">
<input type="hidden" name="cmd" value="client-new">
Nazwa <br>
<input type="text" name="name"
<?php echo 'value="'.$clean->getName().'"';?>>
<br>
Ulica<br>
<input type="text" name="street"
<?php echo 'value="'.$clean->getStreet().'"';?>>
<br>
Kod pocztowy<br>
<input type="text" name="zipCode"
<?php echo 'value="'.$clean->getZipCode().'"';?>>
<br>
Miejscowość<br>
<input type="text" name="city"
<?php echo 'value="'.$clean->getCity().'"';?>>
<br>
NIP<br>
<input type="text" name="nip"><br>
<input type="submit" name="submit" value="Dodaj">
</form>
