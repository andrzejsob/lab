<h4>Dane użytkownika</h4>
Login:
<input type="text" name="nick" value="<?php echo $user->getNick();?>">
<br>
Imię:
<input type="text" name="first_name" value="<?php echo $user->getFirstName();?>">
<br>
Nazwisko:
<input type="text" name="last_name" value="<?php echo $user->getLastName();?>">
<br>
Email:
<input type="text" name="last_name" value="<?php echo $user->getLastName();?>">
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
