<?php if (isset($messageType)) { ?>
<div class="alert <?php echo $messageType?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?php echo $message;?>
</div>
<?php } ?>
<h4>Lista użytkowników</h4>
<a class="add" href="?cmd=user-form">Nowy użytkownik</a>
<table class="list_table">
    <tr>
        <th>Login</th>
        <th>Imię</th>
        <th>Nazwisko</th>
        <th>Email</th>
        <th>Usuń</th>
    </tr>
    <?php foreach ($users as $user) {?>
    <tr>
        <td><?php echo $user->getNick();?></td>
        <td><?php echo $user->getFirstName();?></td>
        <td><?php echo $user->getLastName();?></td>
        <td><?php echo $user->getEmail();?></td>
        <td>
            <a class="delete" href="?cmd=user-delete&id=<?php echo $user->getId();?>">
                Usuń
            </a>
            <a class="edit" href="?cmd=user-form&id=<?php echo $user->getId();?>">
                Edytuj
            </a>
        </td>
    </tr>
    <?php } ?>
</table>
