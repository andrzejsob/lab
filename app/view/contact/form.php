<?php foreach ($errors as $key => $value) {
    echo '<p style="color: red">'.$value.'</p>';
} ?>
<h5>Kontakt dla klienta</h5>
<form method="post">
<select name="clientId">
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
<h5>Dane osoby do kontaktu</h5>
<table>
    <tr>
        <td>Imię</td>
        <td><input type="text" name="firstName" <?php echo 'value="'.
        $entity->getFirstName().'"';?>>
        </td>
    </tr>
    <tr>
        <td>Nazwisko</td>
        <td><input type="text" name="lastName" <?php echo 'value="'.
        $entity->getLastName().'"';?>>
    </tr>
    <tr>
        <td>Email</td>
        <td><input type="text" name="email" <?php echo 'value="'.
        $entity->getEmail().'"';?>>
    </tr>
    <tr>
        <td>Email 2</td>
        <td><input type="text" name="email2" <?php echo 'value="'.
        $entity->getEmail2().'"';?>>
    </tr>
    <tr>
        <td>Phone</td>
        <td><input type="text" name="phone" <?php echo 'value="'.
        $entity->getPhone().'"';?>>
    </tr>
</table>
<br />
<input type="submit" name="save" value="Zapisz">
</form>
