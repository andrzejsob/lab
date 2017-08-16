<?php
require_once '../vendor/autoload.php';
use lab\mapper\MethodMapper;

$appHelper = \lab\base\ApplicationHelper::instance();
$appHelper->init();

$mm = new MethodMapper();
$methods = $mm->findAll();

$user = new \lab\domain\User();
$user = $user->find(4);
$userMethods = $user->getMethods();
$mArray = [];
foreach ($userMethods as $method) {
    $mArray[$method->getAcronym()] = $method->getId();
}
echo '<br>Użytkownik: '.$user->getNick(). '<br>';
?>
<form method="post">
<?php foreach ($methods as $method) { ?>
<input type="checkbox" name="method[]"
value="<?php echo $method->getId()?>"
<?php if (isset($mArray[$method->getAcronym()])) echo 'checked="checked"'?>>
<?php echo $method->getAcronym()?>
<br>
<?php } ?>
</form>
