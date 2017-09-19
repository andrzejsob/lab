<h3>Klient</h3>
<?php
foreach ($errors as $key => $value) {
    echo '<p style="color: red">'.$value.'</p>';
}
?>
<form method="post">
    <table>
        <tr>
            <td>Nazwa</td>
            <td><input type="text" name="name" <?php echo 'value="'.
            $entity->getName().'"';?>>
        </tr>
        <tr>
            <td>Ulica</td>
            <td><input type="text" name="street" <?php echo 'value="'.
            $entity->getStreet().'"';?>>
        </tr>
        <tr>
            <td>Kod pocztowy</td>
            <td><input type="text" name="zipCode" <?php echo 'value="'.
            $entity->getZipCode().'"';?>>
        </tr>
        <tr>
            <td>Miejscowość</td>
            <td><input type="text" name="city" <?php echo 'value="'.
            $entity->getCity().'"';?>>
        </tr>
        <tr>
            <td>NIP</td>
            <td><input type="text" name="nip" <?php echo 'value="'.
            $entity->getNip().'"';?>>
        </tr>
    </table>
    <input type="submit" name="save" value="Zapisz">
</form>
