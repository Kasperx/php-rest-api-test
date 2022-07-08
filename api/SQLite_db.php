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
		// $iniArray = parse_ini_file("../.database.ini", true);
		// $dbhost=$iniArray['db_data_source_name']['host'];
		// $dbuser=$iniArray['db_general']['user'];
		// $dbpass=$iniArray['db_general']['password'];
		// $dbname=$iniArray['db_data_source_name']['dbname'];

		$fileName = __DIR__."/../database.db";
		if(!file_exists($fileName)){
			fopen($fileName, 'w');
		}
		$dbConnection = new PDO("sqlite:".$fileName);
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
	
	public function getAllTimes(){
        $sql = "SELECT * FROM workday_random group by date";
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
		$tableName = 'usertable';
		/////////////////////////////////////
		// $sql = "drop table if exists $tableName";
		// $stmt = $this->db->prepare($sql); 
		// $status = $stmt->execute();
		$sql = "create table if not exists $tableName("
		."id integer primary key autoincrement not null,"
		."firstname text not null,"
		."lastname text not null,"
		."state text,"
		."age int,"
		."pw text"
		.");";
		// create table usertable (id serial, firstname varchar(20) not null, surname varchar(20) not null, age int, pw int, primary key (id)) engine=innodb;
		$stmt = $this->db->prepare($sql);
		$status = $stmt->execute();
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
	public function insertTime($personId, $date, $timeFrom, $timeUntil)
	{
		$tableName = 'workday_random';
		$foreignTableName = 'usertable';
		/////////////////////////////////////
		// $sql = "drop table if exists $tableName";
		// $stmt = $this->db->prepare($sql); 
		// $status = $stmt->execute();
		/////////////////////////////////////
		// get random person id
		$sql = "select id from ".$foreignTableName." limit 1";
		$stmt = $this->db->prepare($sql); 
		$id = $stmt->execute();
		/////////////////////////////////////
		$sql = "create table if not exists ".$tableName."("
		."id integer primary key autoincrement not null,"
		."person_id integer,"
		."date text not null,"
		."from_time text not null,"
		."until_time text,"
		."foreign key (person_id) references ".$foreignTableName." (id)"
		.");";
		// create table usertable (id serial, firstname varchar(20) not null, surname varchar(20) not null, age int, pw int, primary key (id)) engine=innodb;
		$stmt = $this->db->prepare($sql);
		$status = $stmt->execute();
		/////////////////////////////////////
		$sql = "delete from $tableName;";
		$stmt = $this->db->prepare($sql);
		$status = $stmt->execute();
		/////////////////////////////////////
		// get random data from faker api
		// for($count=0; $count<10; $count++)
		for($count=0; $count<rand(1,10); $count++)
		{
			$faker = Faker\Factory::create();
			// $person = new person($faker->firstName, $faker->lastName, rand(0, 100), getRandomString(), $faker->state);
			// array_push($array, $person);
			$sql = "insert into $tableName ("
			."person_id, date, from_time, until_time"
			.") values ("
			."$id,"
			."'".$faker->date('Y_m_d')."',"
			."'".$faker->time()."',"
			."'".$faker->time()."'"
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
