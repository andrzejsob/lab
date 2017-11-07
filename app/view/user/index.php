<?php if (isset($messageType)) { ?>
<div class="alert <?php echo $messageType?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?php echo $message;?>
</div>
<?php } ?>
<h4>Lista użytkowników</h4>
<a class="add" href="?cmd=user-new">Nowy użytkownik</a>
<table class="list_table">
    <tr>
        <th>Login</th>
        <th>Imię</th>
        <th>Nazwisko</th>
        <th>Email</th>
    </tr>
    <?php foreach ($users as $user) {?>
    <tr>
        <td class="feature"><?php echo $user->getUsername();?></td>
        <td class="feature"><?php echo $user->getFirstName();?></td>
        <td class="feature"><?php echo $user->getLastName();?></td>
        <td class="feature"><?php echo $user->getEmail();?></td>
        <td>
            <?php if (isset($buttons['user-edit'])) {?>
            <a class="edit" href="?cmd=user-edit&id=<?php echo $user->getId();?>">
                Edytuj
            </a>
            <?php } ?>
            <?php if (isset($buttons['user-delete'])) {?>
                <a class="delete" href="?cmd=user-delete&id=<?php echo $user->getId();?>">
                    Usuń
                </a>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
