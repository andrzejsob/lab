<h4>Metody użytkownika</h4>
<form method="post">
<?php foreach ($methods as $method) { ?>
<input type="checkbox" name="method[]" value="<?php echo $method->getId()?>"
<?php if (isset($userMethods[$method->getAcronym()])) echo 'checked="checked"'?>>
<?php echo $method->getAcronym()?>
<br>
<?php } ?>
<input type="submit" name="submit" value="Zapisz">
</form>
