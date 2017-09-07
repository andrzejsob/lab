<?php if (isset($messageType)) { ?>
<div class="alert <?php echo $messageType?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?php echo $message;?>
</div>
<?php } ?>
<h4>Typy kont użytkowników</h4>
<a class="add" href="?cmd=role-form">Nowy typ konta</a>
<table class="list_table">
    <tr>
        <th>Nazwa</th>
        <th>Opcje</th>
    </tr>
    <?php foreach ($roles as $role) {?>
    <tr>
        <td><?php echo $role->getName();?></td>
        <td>
            <a class="delete" href="?cmd=role-delete&id=<?php echo $role->getId();?>">
                Usuń
            </a>
            <a class="edit" href="?cmd=role-form&id=<?php echo $role->getId();?>">
                Edytuj
            </a>
        </td>
    </tr>
    <?php } ?>
</table>
