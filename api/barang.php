<?php

require_once '../vendor/autoload.php';

Class Barang {
	
	public function __construct(){
		$this->db = $this->getDB();
	}

	// Connect Database
	private function getDB()
	{
		// $dbhost="localhost";
		// $dbuser="testuser";
		// $dbpass="password";
		// $dbname="test";
		$iniArray = parse_ini_file("../.database.ini", true);
		$dbhost=$iniArray['db_data_source_name']['host'];
		$dbuser=$iniArray['db_general']['user'];
		$dbpass=$iniArray['db_general']['password'];
		$dbname=$iniArray['db_data_source_name']['dbname'];

		$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
		// $dbConnection = new PDO("mysql:host=".$iniArray['host']
		// .";dbname=".$iniArray['dbname']
		// .", ".$iniArray['user'].", ".$iniArray['password'].);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbConnection;
	}

	public function getAll(){
        $sql = "SELECT * FROM usertable";
        $stmt = $this->db->query($sql); 
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
	}

	public function get($id){
        $sql = "SELECT * FROM usertable WHERE id=?";
        $stmt = $this->db->prepare($sql); 
        $stmt->execute(array($id));
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return $data;
	}

	public function insert($namaBarang, $kategori, $stok, $hargaBeli, $hargaJual){
        $sql = "INSERT INTO barang (namaBarang, kategori, stok, hargaBeli, hargaJual) VALUES (?,?,?,?,?)";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($namaBarang, $kategori, $stok, $hargaBeli, $hargaJual));
        return $status;
	}

	public function update($idBarang, $namaBarang, $kategori, $stok, $hargaBeli, $hargaJual){
        $sql = "UPDATE barang SET namaBarang=?, kategori=?, stok=?, hargaBeli=?, hargaJual=? WHERE idBarang=?";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($namaBarang, $kategori, $stok, $hargaBeli, $hargaJual, $idBarang));
        return $status;
	}

	public function delete($idBarang)
	{
        $sql = "DELETE FROM barang WHERE idBarang=?";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($idBarang));
        return $status;
	}
	// get random string
	private function getRandomString()
	{
		// $i = 0;
		// $possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		// $keys_length = strlen($possible_keys);
		// $str = "";
		// while($i<$max) {
		// 	$rand = mt_rand(1,$keys_length-1);
		// 	$str.= $possible_keys[$rand];
		// 	$i++;
		// }
		$str = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
		return $str;
	}
	public function insertRandom()
	{
		/////////////////////////////////////
		// $sql = "drop table if exists usertable";
		// $stmt = $this->db->prepare($sql); 
		// $status = $stmt->execute();
		// $sql = "create table if not exists usertable("
		// ."id serial,"
		// ."firstname varchar(20) not null,"
		// ."lastname varchar(20) not null,"
		// ."state varchar(20),"
		// ."age int,"
		// ."pw varchar(20),"
		// ."primary key (id)) engine=innodb;";
		// // create table usertable (id serial, firstname varchar(20) not null, surname varchar(20) not null, age int, pw int, primary key (id)) engine=innodb;
		// $stmt = $this->db->prepare($sql);
		// $status = $stmt->execute();
		/////////////////////////////////////
		$sql = "delete from usertable;";
		$stmt = $this->db->prepare($sql);
		$status = $stmt->execute();
		/////////////////////////////////////
		// get random data from faker api
		// for($count=0; $count<10; $count++)
		for($count=0; $count<rand(1,50); $count++)
		{
			$faker = Faker\Factory::create();
			// $person = new person($faker->firstName, $faker->lastName, rand(0, 100), getRandomString(), $faker->state);
			// array_push($array, $person);
			$sql = "insert into usertable ("
			."firstname, lastname, state, age, pw"
			.") values ("
			// .$faker->firstName.",".$faker->lastName.",".rand(0, 100).",".getRandomString().",".$faker->state
			."'".$faker->firstName."',"
			."'".$faker->lastName."',"
			."'".$faker->state."',"
			.rand(0, 100).","
			."'".$this->getRandomString()."'"
			.");";
			$stmt = $this->db->prepare($sql); 
			$stmt->execute();
		}
		// get random data from faker api
        // return;
	}
	public function printRandom()
	{
		/////////////////////////////////////
		$sql = "drop table if exists usertable";
		$stmt = $this->db->prepare($sql); 
		$status = $stmt->execute();
		$sql = "create table if not exists usertable("
		."id serial,"
		."firstname varchar(20) not null,"
		."lastname varchar(20) not null,"
		."state varchar(20),"
		."age int,"
		."pw varchar(20),"
		."primary key (id)) engine=innodb;";
		// create table usertable (id serial, firstname varchar(20) not null, surname varchar(20) not null, age int, pw int, primary key (id)) engine=innodb;
		$stmt = $this->db->prepare($sql);
		$status = $stmt->execute();
		/////////////////////////////////////
		// $sql = "delete from usertable;";
		// $stmt = $this->db->prepare($sql);
		// $status = $stmt->execute();
		/////////////////////////////////////
		// get random data from faker api
		for($count=0; $count<10; $count++)
		{
			$faker = Faker\Factory::create();
			// $person = new person($faker->firstName, $faker->lastName, rand(0, 100), getRandomString(), $faker->state);
			// array_push($array, $person);
			$sql = "insert into usertable ("
			."firstname, lastname, state, age, pw"
			.") values ("
			// .$faker->firstName.",".$faker->lastName.",".rand(0, 100).",".getRandomString().",".$faker->state
			."'".$faker->firstName."',"
			."'".$faker->lastName."',"
			."'".$faker->state."',"
			.rand(0, 100).","
			."'".$this->getRandomString()."'"
			.")";
			$stmt = $this->db->prepare($sql); 
			$stmt->execute();
			echo $sql;
		}
		// get random data from faker api
        // return;
	}
}
?>