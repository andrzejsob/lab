<?php if (isset($messageType)) { ?>
<div class="alert <?php echo $messageType?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?php echo $message;?>
</div>
<?php } ?>
<h4>Metody badawcze</h4>
<a class="add" href="?cmd=method-new">Nowa metoda</a>
<table class="list_table">
    <tr>
        <th>Akronim</th>
        <th>Opis</th>
    </tr>
    <?php foreach ($methods as $method) {?>
    <tr>
        <td class="feature"><?php echo $method->getAcronym();?></td>
        <td class="feature"><?php echo $method->getName();?></td>
        <td>
            <a class="delete" href="?cmd=method-delete&id=<?php echo $method->getId();?>">
                Usuń
            </a>
            <a class="edit" href="?cmd=method-edit&id=<?php echo $method->getId();?>">
                Edytuj
            </a>
        </td>
    </tr>
    <?php } ?>
</table>
