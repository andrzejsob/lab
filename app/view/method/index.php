<?php if (isset($messageType)) { ?>
<div class="alert <?php echo $messageType?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?php echo $message;?>
</div>
<?php } ?>
<h4>Metody badawcze</h4>
<a class="add" href="?cmd=method-form">Nowa metoda</a>
<table class="list_table">
    <tr>
        <th>Akronim</th>
        <th>Opcje</th>
    </tr>
    <?php foreach ($methods as $method) {?>
    <tr>
        <td><?php echo $method->getAcronym();?></td>
        <td>
            <a class="delete" href="?cmd=method-delete&id=<?php echo $method->getId();?>">
                Usuń
            </a>
            <a class="edit" href="?cmd=method-form&id=<?php echo $method->getId();?>">
                Edytuj
            </a>
        </td>
    </tr>
    <?php } ?>
</table>
