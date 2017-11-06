<?php foreach ($errors as $key => $value) {
    echo '<p style="color: red">'.$value.'</p>';
} ?>
<form method="post">
Nazwa:<br>
<input type="text" name="name" value="<?php echo $entity->getName();?>">
<h4>Dostęp do paneli</h4>
<?php foreach ($permissions as $perm) {?>
<input type="checkbox" name="permissions[]"
    value="<?php echo $perm->getId();?>"
    <?php if(in_array($perm->getId(), $checkedPermIdArray)) { ?>
        <?php echo 'checked=checked';?>
    <?php } ?>
>
<?php echo $perm->getName();?><br>
<?php } ?>
<input type="submit" name="save" value="Zapisz">
</form>
