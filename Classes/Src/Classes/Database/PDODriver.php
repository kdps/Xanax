<?php

class PDODriver {
	
	private $connection;
	
	public function Connect ( string $host = 'localhost', string $database, string $username, string $password ) {
		try {
			$dns = ('mysql:' . implode(';', isset($database) ? [
				'dbname=' . $database,
				'host=' . $host
			] : [
				'host=' . $host
			]));
			
			$attributes = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
				PDO::ATTR_TIMEOUT => 5,
				PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_EMULATE_PREPARES=>FALSE
			);
			
			$pdo = new PDO($dns, $username, $password, $attributes);
			
			$this->connection = $pdo;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
}