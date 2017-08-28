<?php foreach ($errors as $error) {?>
<?php echo $error;?><br>
<?php } ?>
<form method="post">
<input type="text" name="name" value="<?php echo $entity->getName();?>"><br>
<?php foreach ($permissions as $perm) {?>
<input type="checkbox" name="permission[]" value="<?php echo $perm->getId();?>">
<?php echo $perm->getName();?><br>
<?php } ?>
<input type="submit" name="save" value="Zapisz">
</form>
