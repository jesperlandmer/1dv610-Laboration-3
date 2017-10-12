<?php

namespace model;

require_once('PDOConnection.php');

class PDOService extends PDOConnection
{

  const PDO_USERNAME = "username";
  const PDO_PASSWORD = "password";

    public function saveData(array $data) : \PDOStatement
    {
        try {

            $PDOStatement = $this->prepareStatement($this->getSaveStatement());
            $this->executeStatement($PDOStatement, $data);
        } catch (\PDOException $err) {

            throw new \Exception($err);
        }

        return $PDOStatement;
    }

    public function findData(array $data) : \PDOStatement
    {
        try {

            $PDOStatement = $this->prepareStatement($this->getFindStatement($data));
            $this->executeStatement($PDOStatement, $data);
        } catch (\PDOException $err) {

            throw new \Exception($err);
        }

        return $PDOStatement;
    }

    private function prepareStatement(string $statement) : \PDOStatement
    {
        return parent::getDBConnection()->prepare($statement);
    }

    private function executeStatement(\PDOStatement $statement, array $data) : bool
    {
        return $statement->execute($data);
    }

    private function getSaveStatement() : string
    {
        return 'INSERT INTO Users(username, password) VALUES(:username, :password)';
    }

    private function getFindStatement(array $data) : string
    {
        $sql = 'SELECT * FROM Users WHERE ';
    
        foreach ($data as $key => $value) {
            $sql .= $key . '=:' . $key;
            if (end($data) != $value) {
                $sql .= ' AND ';
            }
        }
        
        return $sql;
    }
}
