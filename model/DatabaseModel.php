<?php

namespace model;

require_once("dbHelpers/PDOService.php");

class DatabaseModel
{
    private static $cost = "cost";

    public function __construct()
    {
        $this->dbHelper = new PDOService();
    }

    public function getUserFromDatabase(string $username) : \PDOStatement
    {
        assert(isset($username));

        return $this->dbHelper->findData(array(
            PDOVariables::DB_USERNAME_COLUMN => $username
        ));
    }

    public function updateUserFromDatabase(string $username, string $password) : \PDOStatement
    {
        assert(isset($username));
        assert(isset($password));

        return $this->dbHelper->editData(array(
            PDOVariables::DB_USERNAME_COLUMN => $username,
            PDOVariables::DB_PASSWORD_COLUMN => $this->getPasswordHash($password)
        ));
    }

    public function saveUserToDatabase(string $username, string $password)
    {
        assert(isset($username));
        assert(isset($password));

        $this->userData = $this->dbHelper->saveData(array(
            PDOVariables::DB_USERNAME_COLUMN => $username,
            PDOVariables::DB_PASSWORD_COLUMN => $this->getPasswordHash($password)
        ));
    }

    public function isExistingUser(string $username, string $password) : bool
    {
        return password_verify($password, $this->getDBUserPassword($username));
    }

    private function getPasswordHash(string $password) : string
    {
        return password_hash("$password", PASSWORD_BCRYPT, [self::$cost => 8]);
    }

    private function getDBUserPassword(string $username) : string
    {
        return $this->getUserFromDatabase($username)->fetch()[PDOVariables::DB_PASSWORD_COLUMN];
    }
}
