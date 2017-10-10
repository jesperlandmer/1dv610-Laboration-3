<?php

namespace model;

require_once('PDOConnection.php');

class PDOService extends PDOConnection {

  /**
	 * @return PDOStatement
	 */
  public function saveData(array $data) {
    $PDOStatement = $this->prepareStatement($this->getSaveStatement());
    $this->executeStatement($PDOStatement, $data);
    return $PDOStatement;
  }

  /**
	 * @return PDOStatement
	 */
  public function findData(array $data) {
    $PDOStatement = $this->prepareStatement($this->getFindStatement($data));
    $this->executeStatement($PDOStatement, $data);
    return $PDOStatement;
  }

  private function prepareStatement(string $statement) 
  {
    return parent::getDBConnection()->prepare($statement);
  }

  private function executeStatement(\PDOStatement $statement, array $data) 
  {
    return $statement->execute($data);
  }

  private function getSaveStatement() 
  {
    return 'INSERT INTO Users(username, password) VALUES(:username, :password)';
  }

  private function getFindStatement(array $data) 
  {
    $sql = 'SELECT * FROM Users WHERE ';
    
        foreach($data as $key => $value)
        {
          $sql .= $key . '=:' . $key;
          if(end($data) != $value){
            $sql .= ' AND ';
          }
        }
        
    return $sql;
  }
}