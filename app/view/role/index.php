<?php if (isset($messageType)) { ?>
<div class="alert <?php echo $messageType?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?php echo $message;?>
</div>
<?php } ?>
<h4>Typy kont użytkowników</h4>
<a class="add" href="?cmd=role-new">Nowy typ konta</a>
<table class="list_table">
    <tr>
        <th>Nazwa</th>
        <th>Dostęp do paneli</th>
    </tr>
    <?php foreach ($roles as $role) {?>
    <tr>
        <td class="feature"><?php echo $role->getName();?></td>
        <td class="feature">
            <ul style="list-style-type: none; margin: 0; padding: 0;">
            <?php foreach ($permissions = $role->getPermissions() as $permission) {?>
            <li><?php echo $permission->getDescription();}?></li>
            </ul>
        </td>
        <td>
            <?php if (isset($buttons['role-edit'])) {?>
                <a class="edit" href="?cmd=role-edit&id=<?php echo $role->getId();?>">
                    Edytuj
                </a>
            <?php }?>
            <?php if (isset($buttons['role-delete'])) {?>
            <a class="delete" href="?cmd=role-delete&id=<?php echo $role->getId();?>">
                Usuń
            </a>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
