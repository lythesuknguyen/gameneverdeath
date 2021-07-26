<?php

namespace Packages\System;

use \PDO;


trait DBConnect{
	private $db_type = DB_TYPE;
	private $db_host = DB_HOST;
	private $db_user = DB_USER;
	private $db_password = DB_PASSWORD;
	public $db_name = null;
	private $db_charset = DB_CHARSET;
	protected $conn;
	protected $connect_result;

	public function Connect(){		
		$dsn = "$this->db_type:host=$this->db_host;dbname=$this->db_name";
		$options = array(
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $this->db_charset",
					//PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_ERRMODE    => PDO::ERRMODE_SILENT,
					//PDO::ATTR_PERSISTENT => true
		);
		try {
			$this->conn = new PDO($dsn,$this->db_user,$this->db_password,$options);
			
			return $this->connect_result = "Connected successfully";
		} 
		catch (PDOException $e){
			return $this->connect_result = "Connection failed: " . $e->getMessage();
			exit();
		}		
	}
	
	function SelectDB($new_db=null){
		if( $new_db != null){
			$this->db_name = $new_db;
			$this->Connect();
		} else {
			$this->db_name = DB_NAME;
			$this->Connect();
		}
	}

	public function TestConnection(){		
		return $this->connect_result;
	}

	function __construct(){
		$this->SelectDB($new_db=null);
	}

	function __destruct(){
		$this->conn = null;
	}
	

	public function Push($sql, $args){
		$query = $this->conn->prepare($sql);
		$query->execute($args);
		$rows = $query->rowCount();
		return $rows;
	}
	
	public function Fetch($sql, $args){
		$query = $this->conn->prepare($sql);
		$query->execute($args);
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$rows = $query->fetchAll();
		return $rows;
	}
	
	public function RowsCount($sql, $args){
		$query = $this->conn->prepare($sql);
		$query->execute($args);
		$rows = $query->rowCount();
		return $rows;
	}
	
}
