<?php
function __autoload ($class_name){
	include 'classes/'.$class_name.'.php';
};
$_db = DB::getInstance();
?>
<form name='Outer' method='post' action=''>
	Страна: <br />
	<select name='country'>
		<option  value=""> Выберите страну</option>
		<option  value="Ukraine"> Ukraine</option>
		<option  value="Russia"> Russia</option>
		<option  value="Belarus"> Belarus</option>
	</select>
	<input type="submit" name="enter" value="Вывести данные" />
</form>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
	$country = $_POST['country'];
	foreach ($_db -> selectOData($country) as $row){
	echo "Валюта: ".$row['currency']." Курс: ".$row['price']."<br>";
}

?>