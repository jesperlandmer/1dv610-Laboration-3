<?php

namespace model;

require_once('PDOVariables.php');

class PDOConnection {

  private $dbHost = PDOVariables::DB_HOST;
  private $dbName = PDOVariables::DB_NAME;
  private $dbUser = PDOVariables::DB_USER;
  private $dbPass = PDOVariables::DB_PASS;
  private $dbConnect;

  public function __construct() 
  {
    try {

      $this->dbConnect = new \PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass);
      $this->dbConnect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    catch (\PDOException $err) {

      throw new PDOException("DB Connection failed");
      die();
    }
  }

  protected function getDBConnection() : \PDO
  {
    if ($this->dbConnect instanceof \PDO) {
     return $this->dbConnect;
    }
  }
}