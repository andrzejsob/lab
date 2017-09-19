<h4>Logowanie</h4>
<?php
//if (isset($errors)) {
    foreach ($errors as $key => $value) {
        echo '<p style="color: red">'.$value.'</p>';
    }
//}
?>
<form method="post">
<table>
    <tr>
        <td>Login</td>
        <td><input type="text" name="nick" value="<?php echo $entity->getNick();?>"></td>
    </tr>
    <tr>
        <td>Hasło</td>
        <td><input type="password" name="password"></td>
    </tr>
</table>
<input type="submit" name="save" value="Zaloguj">
</form>
