<h3>Nowy klient</h3>
<?php
if ($errors) {
    foreach ($errors as $key => $value) {
        echo '<p style="color: red">'.$value.'</p>';
    }
}
?>
<form method="post">
<input type="hidden" name="cmd" value="client-new">
Nazwa <br>
<input type="text" name="name"><br>
Ulica <br>
<input type="text" name="street"><br>
Kod pocztowy <br>
<input type="text" name="zip_code"><br>
Miejscowość <br>
<input type="text" name="city"><br>
NIP <br>
<input type="text" name="nip"><br>
<input type="submit" name="submit" value="Dodaj">
</form>
