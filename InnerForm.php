<?php
function __autoload ($class_name){
	include 'classes/'.$class_name.'.php';
 };
?>
<!DOCTYPE HTML>
<form name="f1" method="post" action="">
Страна: <br />
<input name="country" type="text" size="25" maxlength="30" value="" /> <br />
Валюта: <br />
<input name="currency" type="text" size="25" maxlength="30" value="" /> <br />
Цена:<br />
<input name="price" type="text" size="25" maxlength="30" value="" /> <br />
<input type="submit" name="enter" value="Запомнить" />
</form>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$country = $_POST['country'];
		$currency = $_POST['currency'];
		$price = $_POST['price'];
}
$obj = new InnerData($country,$currency,$price);
$obj -> setCurrency();
$obj -> setPrice();
$obj  -> setCountry();
?>