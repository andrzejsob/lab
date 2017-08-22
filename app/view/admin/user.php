<h4>Dane użytkownika</h4>
<?php
//if (isset($errors)) {
    foreach ($errors as $key => $value) {
        echo '<p style="color: red">'.$value.'</p>';
    }
//}
?>
<form method="post">
Login:
<input type="text" name="nick" value="<?php echo $entity->getNick();?>">
<br>
Imię:
<input type="text" name="firstName" value="<?php echo $entity->getFirstName();?>">
<br>
Nazwisko:
<input type="text" name="lastName" value="<?php echo $entity->getLastName();?>">
<br>
Email:
<input type="text" name="email" value="<?php echo $entity->getEmail();?>">
<br>
<h4>Konta</h4>
...

<h4>Metody badawcze</h4>
<?php foreach ($methods as $method) { ?>
<input type="checkbox" name="method[]" value="<?php echo $method->getId()?>"
<?php if (isset($userMethods[$method->getAcronym()])) echo 'checked="checked"'?>>
<?php echo $method->getAcronym()?><br>
<?php } ?>
<input type="submit" name="save" value="Zapisz">
</form>
