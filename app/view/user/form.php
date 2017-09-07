<h4>Dane użytkownika</h4>
<?php
//if (isset($errors)) {
    foreach ($errors as $key => $value) {
        echo '<p style="color: red">'.$value.'</p>';
    }
//}
?>
<form method="post">
<table>
    <tr>
        <td>Login</td>
        <td><input type="text" name="nick" value="<?php echo $entity->getNick();?>"></td>
    </tr>
    <tr>
        <td>Imię</td>
        <td><input type="text" name="firstName" value="<?php echo $entity->getFirstName();?>"></td>
    </tr>
    <tr>
        <td>Nazwisko</td>
        <td><input type="text" name="lastName" value="<?php echo $entity->getLastName();?>"></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><input type="text" name="email" value="<?php echo $entity->getEmail();?>"></td>
    </tr>
</table>

<h4>Typ konta</h4>
<?php foreach ($roles as $role) { ?>
<input type="checkbox" name="role[]" value="<?php echo $role->getId()?>"
<?php if (isset($userRoles[$role->getName()])) echo 'checked="checked"'?>>
<?php echo $role->getName()?><br>
<?php } ?>
<h4>Metody badawcze</h4>
<?php foreach ($methods as $method) { ?>
<input type="checkbox" name="method[]" value="<?php echo $method->getId()?>"
<?php if (isset($userMethods[$method->getAcronym()])) echo 'checked="checked"'?>>
<?php echo $method->getAcronym()?><br>
<?php } ?>
<input type="submit" name="save" value="Zapisz">
</form>
