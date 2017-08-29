<h4>Typy kont użytkowników</h4>
<a href="?cmd=role-form">Nowy</a>
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
