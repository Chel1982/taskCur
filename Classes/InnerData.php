<?php
class InnerData {
	private $country;
	private $currency;
	private $price;
	private $_db;
	
	/*Получаем в конструктор данные из формы*/
	public function __construct($country,$currency,$price)	{
		$this->_db = DB::getInstance();
		if (empty($country) or empty($currency) or empty($price)){
	echo "<h1>Заполните все поля или заполните поля правильно!!!</h1>";
	exit;
		}else{
			$this -> country = $country;
			$this -> currency = $currency;
			$this -> price = abs((float)$price);
		}
	}

	/*Вписываем название валюты в БД*/
	function setCurrency (){
		try{
		$this->_db->setCurrency($this->currency);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	/*Вписываем цену валюту в БД*/
	function setPrice (){
		try{
		$this->_db->setPrice($this->price);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	/*Вписываем название страны в БД*/
	function setCountry (){
		try{
		$this->_db->setCountry($this->country,$this->currency,$this->price);
		}catch(PDOException $e){
			echo $e->getMessage();

		}
	}
}
?>