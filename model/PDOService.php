<?php

namespace model;

require_once(__DIR__ . '/../libs/Connection.php');

class PDOService extends Connection {

  /**
	 * @return PDOStatement
	 */
  public function saveData($data) {
    $sql = 'INSERT INTO Users(username, password) VALUES(:username, :password)';
    $stmt = parent::getDBConnection()->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  /**
	 * @return PDOStatement
	 */
  public function findData($data) {
    $sql = 'SELECT * FROM Users WHERE ';

    foreach($data as $key => $value)
    {
      $sql .= $key . '=:' . $key;
      if(end($data) != $value){
        $sql .= ' AND ';
      }
    }

    $stmt = parent::getDBConnection()->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }
}