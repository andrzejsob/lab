<?php if (isset($messageType)) { ?>
<div class="alert <?php echo $messageType?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?php echo $message;?>
</div>
<?php } ?>
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
        <td><input type="text" name="username" value="<?php echo $entity->getUsername();?>"></td>
    </tr>
    <tr>
        <td>Hasło</td>
        <td><input type="password" name="password"></td>
    </tr>
</table>
<p>
    <small>
        <a style="text-decoration: none" href="?cmd=login-forgotPassword">
            Przypomnij hasło.
        </a>
    </small>
</p>
<input type="submit" name="save" value="Zaloguj">
</form>
