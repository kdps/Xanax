<?php

declare(strict_types=1);

namespace Xanax\Classes\Database\Driver;

class PHPDataObject extends \PDO
{

	public function __construct(string $host = 'localhost', string $database, string $username, string $password)
	{
		try {
			$dns = ('mysql:' . implode(';', isset($database) ? [
				'dbname=' . $database,
				'host=' . $host
			] : [
				'host=' . $host
			]));

			$attributes = [
				\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
				\PDO::ATTR_TIMEOUT            => 5,
				\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
				\PDO::ATTR_EMULATE_PREPARES   => false,
				\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
			];

			parent::__construct($dns, $username, $password, $attributes);
		} catch (\Exception $e) {
			throw new \Exception($e->getMessage());
		}
	}

	public function insertByArray($table, $columns, $values) {
		$column_count = count($columns);
		$column_separated = implode(",", $columns);
		$placeholder_separated = implode(",", array_fill(0, $column_count, "?"));
		$sql = "INSERT INTO $table ($column_separated) VALUES ($placeholder_separated)";

		$stmt= $this->prepare($sql);
		$stmt->execute($values);
	}

}
