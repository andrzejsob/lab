<h4>Przypominanie hasła</h4>
<p>Nowe hasło zostanie wysłane na podany adres e-mail</p>
<?php
    foreach ($errors as $key => $value) {
        echo '<p style="color: red">'.$value.'</p>';
    }
?>
<form method="post">
<table>
    <tr>
        <td>E-mail</td>
        <td><input type="text" name="email"
            value="<?php echo $entity->getEmail();?>"
            >
        </td>
    </tr>
</table>
<p>
    <input type="submit" name="save" value="Wyślij">
</p>
</form>
