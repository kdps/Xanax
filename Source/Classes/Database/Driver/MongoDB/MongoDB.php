<?php

class MongoDB
{

  private $database_name;
  
  private $connection;
  
  public function __construct(string $connection, string $database)
  {
    $scheme = "mongodb://";
    
    $this->database_name = $database;
    
    $this->connection = new MongoDB\Driver\Manager("$scheme$connection");
  }
    
  public function executeQuery($collection_name, $query, $option)
  {
    $query = new MongoDB\Driver\Query($query, $option); 
    
    return $this->connection->executeQuery("$this->database_name.$collection_name", $query);
  }
  
  public function bulkInsert($collection_name, $data)
  {
    $bulk = new MongoDB\Driver\BulkWrite;
    
    $bulk->insert($data);
    
    $manager->executeBulkWrite('$this->database_name.$collection_name', $bulk);
  }
  
}
