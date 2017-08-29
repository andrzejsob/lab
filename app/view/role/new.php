<h4>Nowy typ konta</h4>
<?php foreach ($errors as $error) {?>
<?php echo $error;?><br>
<?php } ?>
<form method="post">
Nazwa:<br>
<input type="text" name="name" value="<?php echo $entity->getName();?>">
<h4>Uprawnienia do konta</h4>
<?php foreach ($permissions as $perm) {?>
<input type="checkbox" name="permission[]"
    value="<?php echo $perm->getId();?>"
    <?php if(isset($rolePermArray[$perm->getName()])) { ?>
        <?php echo 'checked=checked';?>
    <?php } ?>
>
<?php echo $perm->getName();?><br>
<?php } ?>
<input type="submit" name="save" value="Zapisz">
</form>
