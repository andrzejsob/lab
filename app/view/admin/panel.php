<style>
#users {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    max-width: 200px;
}

#users td, #users th {
    border: 1px solid #ddd;
    padding: 8px;
}
#users td {cursor: pointer}

#users tr:nth-child(even){background-color: #f2f2f2;}

#users tr:hover {background-color: #ddd;}
#users tr.button_row {cursor: default; background-color: white}


#users th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}
</style>
<script>

</script>

<h4>Lista użytkowników</h4>
<table id="users">
    <tr>
        <th>Login</th>
        <th>Imię</th>
        <th>Nazwisko</th>
        <th>email</th>
        <th>Usuń</th>
    </tr>
    <form method="post">
    <?php foreach ($users as $user) {?>
    <tr>
        <td onclick="location.href='?cmd=admin-user&id=<?php echo $user->getId()?>'";>
            <?php echo $user->getNick();?>
        </td>
        <td onclick="location.href='?cmd=admin-user&id=<?php echo $user->getId()?>'";>
            <?php echo $user->getFirstName();?>
        </td>
        <td onclick="location.href='?cmd=admin-user&id=<?php echo $user->getId()?>'";>
            <?php echo $user->getLastName();?>
        </td>
        <td onclick="location.href='?cmd=admin-user&id=<?php echo $user->getId()?>'";>
            <?php echo $user->getEmail();?>
        </td>
        <td>
            <input type="checkbox" name="userId[]"
            value="<?php echo $user->getId();?>">
        </td>
    </tr>
    <?php } ?>
    <tr class="button_row">
        <td colspan="5" style="text-align: right"><input type="submit" name="deleteUser" value="Usuń"></td>
    </tr>
    </form>
    <form>
    </form>
    <tr class="button_row">
        <td><input type="text" name="nick"></td>
        <td><input type="text" name="first_name"></td>
        <td><input type="text" name="last_name"></td>
        <td colspan="2"><input type="text" name="email"></td>
    </tr>
    <tr class="button_row">
        <td colspan="5" style="text-align: right"><input type="button" name="addUser" value="Dodaj"></td>
    </tr>
</table>
