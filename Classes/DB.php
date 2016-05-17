<?php
class DB{
	protected $_db = null;
    public static $_instance = null;
    protected $host = "localhost";
    protected $db = "worldcurrency";
    protected $user = "root";
    protected $pass = "";
	
	
	
	protected function __construct(){
		try{
			$this->_db = new PDO("mysql:host = localhost;dbname=worldcurrency",
												"root",
												"");
			$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	
	protected function __clone () {}
		
	public static function  getInstance(){
		try{
		if(!self::$_instance instanceof self)
			self::$_instance = new self;
			return self::$_instance;
		}catch(PDOException $e){
			echo $e->getMessage();
		}		
	}
	/*Вычитываем данные из БД*/
	public function  selectItems (){
		try{
			$arr = array();
			$sql = "SELECT country,currency,price
						FROM country
						INNER JOIN currency ON country.currency_id = currency.id
						INNER JOIN price ON country.price_id = price.id;";
			
			$stmt = $this->_db->query($sql);
			while($row = $stmt -> fetch(PDO::FETCH_ASSOC))
			$arr[] = $row;
			return $arr;
						
			}catch(PDOException $e){
			echo 'HERE--';
			echo $e->getMessage();
		 }
	}
	/*Вычитываем все данные для опеределенной страны*/
	public function selectOData($country){
		try{
			$arr = array();
			$sql = "SELECT country,currency,price
						FROM country
						INNER JOIN currency ON country.currency_id = currency.id
						INNER JOIN price ON country.price_id = price.id
					WHERE country = '$country'";

			$stmt = $this->_db->query($sql);
			while($row = $stmt -> fetch(PDO::FETCH_ASSOC))
				$arr[] = $row;
			return $arr;

		}catch(PDOException $e){
			echo 'HERE--';
			echo $e->getMessage();
		}
	}

	/*Вычитываем название страны из БД*/
	public function  selectBDCountry (){
		try{
			$arr = array();
			$sql = "SELECT DISTINCT country
						FROM country";
			
			$stmt = $this->_db->query($sql);
			while($row = $stmt -> fetch(PDO::FETCH_ASSOC))
			$arr[] = $row;
			return $arr;
						
			}catch(PDOException $e){
			echo 'HERE--';
			echo $e->getMessage();
		}	
	}
	/*Вписываем название валюты в БД*/
	public function setCurrency ($currency){
		try{
		$currency = $this -> _db -> quote($currency);
		$sql = "INSERT INTO currency VALUES (null,$currency)";
		$result = $this->_db->exec($sql);
		if($result === false) die ('ERROR');
		}catch(PDOException $e){
			echo $e->getMessage();
		}		
	}
	/*Вписываем цену валюты в БД*/
	public function setPrice ($price){
		try{
			$sql = "INSERT INTO price VALUES (null,$price)";
			$result = $this->_db->exec($sql);
			if($result === false) die ('ERROR');
		}catch(PDOException $e){
			echo $e->getMessage();
		}		
	}	
	/*Вписываем название страны и внешние ключи в БД*/
	public function setCountry ($country,$currency,$price){
		try{
			/*вычитываем номер внешнего ключа из БД для Price*/
			$sqlP = "SELECT id
					FROM price 
					WHERE price = '$price'";
			$stmtP = $this->_db->query($sqlP);
			foreach ($stmtP as $row){
			$price = $row['id'];}
			/*вычитываем номер внешнего ключа из БД для Currency*/
			$sqlС = "SELECT id
					FROM currency 
					WHERE currency = '$currency'";
			$stmtС = $this->_db->query($sqlС);
			foreach ($stmtС as $row){
			$currency = $row['id'];}
			/*записываем данные в таблицу Country*/
			$country = $this -> _db -> quote ($country);
			$sqlCoun = "INSERT INTO country(country, price_id, currency_id) VALUES($country, $price, $currency)";
			$result = $this->_db->exec($sqlCoun);
			if($result === false) die ('ERROR');
		}catch(PDOException $e){
			echo $e->getMessage();
		}		
	}
}

?>