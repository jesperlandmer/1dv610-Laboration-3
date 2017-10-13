<?php

namespace model;

require_once('PDOConnection.php');

class PDOService extends PDOConnection
{

    private $dbName = PDOVariables::DB_NAME;
    private $usernameColumn = PDOVariables::DB_USERNAME_COLUMN;
    private $passwordColumn = PDOVariables::DB_PASSWORD_COLUMN;

    public function saveData(array $data) : \PDOStatement
    {
        $PDOStatement = $this->prepareStatement($this->getSaveStatement());
        $this->executeStatement($PDOStatement, $data);

        return $PDOStatement;
    }

    public function editData(array $data) : \PDOStatement
    {
        $PDOStatement = $this->prepareStatement($this->getEditStatement());
        $this->executeStatement($PDOStatement, $data);

        return $PDOStatement;
    }

    public function findData(array $data) : \PDOStatement
    {
        $PDOStatement = $this->prepareStatement($this->getFindStatement());
        $this->executeStatement($PDOStatement, $data);

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
        return "INSERT INTO $this->dbName($this->usernameColumn, $this->passwordColumn) VALUES(:$this->usernameColumn, :$this->passwordColumn)";
    }

    private function getEditStatement() : string
    {
        return "UPDATE $this->dbName SET $this->passwordColumn = :$this->passwordColumn WHERE $this->usernameColumn = :$this->usernameColumn";
    }

    private function getFindStatement() : string
    {
        return "SELECT * FROM $this->dbName WHERE $this->usernameColumn = :$this->usernameColumn";
    }
}
