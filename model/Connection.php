<?php

namespace model;

class Connection {

  private $dbHost = "localhost";
  private $dbName = "users";
  private $dbUser = "root";
  private $dbPass = "root";
  private $dbConnect;

  /**
	 * Start and handle database connection
	 * @return void
	 */
  public function __construct() {

    try {
      $this->dbConnect = new \PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass);
      $this->dbConnect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    catch (\PDOException $err) {
      throw new Exception("DB Connection failed");
      die();  //  terminate connection
    }
  }

  /**
	 * @return PDO
	 */
  public function getDBConnection() {

    if ($this->dbConnect instanceof \PDO) {
     return $this->dbConnect;
    }
  }
}