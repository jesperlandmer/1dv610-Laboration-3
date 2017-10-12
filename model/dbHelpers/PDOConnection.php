<?php

namespace model;

class PDOConnection {

  private $dbHost = "localhost";
  private $dbName = "users";
  private $dbUser = "root";
  private $dbPass = "root";
  private $dbConnect;

  public function __construct() 
  {
    try {

      $this->dbConnect = new \PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass);
      $this->dbConnect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    catch (\PDOException $err) {

      throw new Exception("DB Connection failed");
      die();  //  terminate connection
    }
  }

  protected function getDBConnection() : \PDO
  {
    if ($this->dbConnect instanceof \PDO) {
     return $this->dbConnect;
    }
  }
}