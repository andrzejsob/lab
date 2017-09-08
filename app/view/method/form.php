<h4>Metoda badawcza</h4>
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
        <td>Akronim</td>
        <td><input type="text" name="acronym" value="<?php echo $entity->getAcronym();?>"></td>
    </tr>
    <tr>
        <td>Opis</td>
        <td><input type="text" name="name" value="<?php echo $entity->getName();?>"></td>
    </tr>
</table>
<input type="submit" name="save" value="Zapisz">
</form>
