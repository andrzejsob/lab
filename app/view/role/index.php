<style>
.alert {
    padding: 15px;
    background-color: #f44336;
    color: white;
    border-radius: 10px;
    font-weight: bold;
}

.alert.success {
    background-color: #4CAF50;
    border: 3px solid green;
}
.alert.info {background-color: #2196F3;}
.alert.warning {background-color: #ff9800;}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 26px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
table {
    border-collapse: collapse;
}
table th, td {
    border: 1px solid black;
}
</style>
<?php if (isset($messageType)) { ?>
<div class="alert <?php echo $messageType?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?php echo $message;?>
</div>
<?php } ?>
<h4>Typy kont użytkowników</h4>
<a class="add" href="?cmd=role-form">Nowy typ konta</a>
<table>
    <tr>
        <th>Nazwa</th>
        <th>Opcje</th>
    </tr>
    <?php foreach ($roles as $role) {?>
    <tr>
        <td><?php echo $role->getName();?></td>
        <td>
            <a href="?cmd=role-delete&id=<?php echo $role->getId();?>">
                Usuń
            </a>
            <a href="?cmd=role-form&id=<?php echo $role->getId();?>">
                Edytuj
            </a>
        </td>
    </tr>
    <?php } ?>
</table>
