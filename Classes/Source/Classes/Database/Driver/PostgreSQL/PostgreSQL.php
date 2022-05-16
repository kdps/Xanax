<?php

class PostgreSQL
{
  private $connection;
  
  public function __construct(string $host = 'localhost', string $database, string $username, string $password)
  {
    $this->connection = pg_connect("host=$host dbname=$database user=$username password=$password");
  }
  
  public function Query($query)
  {
    pg_query($this->connection, $query);
  }
  
  public function Close()
  {
    pg_close($this->connection);
  }
  
  public function getHostname()
  {
    return pg_host($this->connection);
  }
  
  public function fetchRow(\PgSql\Result $result)
  {
    return pg_fetch_row($result);
  }
  
  public function fetchArray(PgSql\Result $result, int $row = null) : array|false
  {
    return pg_fetch_assoc($result, $row);
  }
  
  public function fetchAll(PgSql\Result $result, int $mode = PGSQL_ASSOC) :array
  {
    return pg_fetch_all($result, $mode);
  }
  
  public function affectedRows(\PgSql\Result $result) :int
  {
    return pg_affected_rows($result);
  }
  
  public function cancelQuery()
  {
    return pg_cancel_query($this->connection);
  }
  
  public function getDatabaseName()
  {
    return pg_dbname($this->connection);
  }
  
}
