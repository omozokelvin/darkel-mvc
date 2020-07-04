<?php

namespace libraries;

use PDO;
use PDOException;

/******************************************
 * PDO Database Class                     *
 * Connect to database                    *
 * Create prepared statements             *
 * Bind Values                            *
 * Return rows and results                *
 *****************************************/

class Database {
  private $host = DB_HOST;
  private $user = DB_USER;
  private $password = DB_PASSWORD;
  private $dbName = DB_NAME;

  private $dbHandler;
  private $statement;
  private $error;

  public function __construct() {
    //set DSN
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;

    $options = array(
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    //Create PDO instance

    try {
      $this->dbHandler = new PDO($dsn, $this->user, $this->password, $options);
    } catch (PDOException  $e) {
      $this->error = $e->getMessage();
      echo $this->error;
    }
  }

  //Prepare statement with query
  public function query($sql) {
    $this->statement = $this->dbHandler->prepare($sql);
  }

  //Bind values
  public function bind($param, $value, $type = null) {
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;

        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;

        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;

        default:
          $type = PDO::PARAM_STR;
          break;
      }
    }

    $this->statement->bindValue($param, $value, $type);
  }

  //Execute the prepared statement
  public function execute() {
    return $this->statement->execute();
  }

  //Get result set as array of objects
  public function resultSet() {
    $this->execute();
    return $this->statement->fetchAll(PDO::FETCH_OBJ);
  }

  //Get single record as object 
  public function single() {
    $this->execute();
    return $this->statement->fetch(PDO::FETCH_OBJ);
  }

  //Get row count 
  public function rowCount() {
    return $this->statement->rowCount();
  }

  //Get last insert id
  public function lastInsertId() {
    return $this->dbHandler->lastInsertId();
  }

  //Insert into table
  public function insert(string $tableName, array $data) {
    if (!empty($data) && !empty($tableName)) {

      $keys = array_keys($data);

      $fields = implode(", ", $keys);

      $templateVariable = '';
      foreach ($keys as $key) {
        if (is_string($key)) {
          $templateVariable .= ":$key, ";
        } else {
          return false;
        }
      }

      $templateVariable  = rtrim($templateVariable, ", ");

      //we create the insert query using the array
      $this->query("INSERT into `$tableName` ($fields) VALUES ($templateVariable)");

      //we bind values
      foreach ($data as $key => $value) {
        $this->bind(":$key", $value);
      }

      if ($this->execute()) {
        return $this->lastInsertId();
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  //Update a record
  public function update($tableName, $data, $condition = '') {

    if (!empty($data) && !empty($tableName)) {
      $query = "UPDATE {$tableName} SET ";

      $keys = array_keys($data);
      foreach ($keys as $key) {
        $query .= "$key = :$key, ";
      }

      $query = rtrim($query, ", ");

      //we append condition string if available
      $query .= !empty($condition) ? " WHERE $condition" : '';

      $this->query($query);

      //we bind values
      foreach ($data as $key => $value) {
        $this->bind(":$key", $value);
      }

      //Execute query
      return !!$this->execute() ? true : false;
    } else {
      return false;
    }
  }

  //delete using table name and condition string
  public function delete($tableName, $condition, $limit = '') {

    if (!empty($tableName) && !empty($condition)) {
      //using ternary if condition, if limit is empty, 
      //then do not add limit to query else add limit to query
      $limit = ($limit == '') ? '' : 'LIMIT ' . $limit;
      $query = "DELETE FROM {$tableName} WHERE {$condition} {$limit}";

      $this->query($query);

      //Execute query
      return !!$this->execute() ? true : false;
    }
  }
}
