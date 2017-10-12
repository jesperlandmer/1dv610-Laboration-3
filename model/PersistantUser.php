<?php

namespace model;

require_once("dbHelpers/PDOService.php");

class PersistantUser
{
    private static $username = "PersistantUser::Username";
    private static $password = "PersistantUser::Password";
    private static $passwordRepeat = "PersistantUser::PasswordRepeat";
    private static $message = "PersistantUser::Message";

    public function __construct()
    {
        assert(isset($_SESSION));
        $this->dbHelper = new PDOService();
        $this->validator = new Validator();
    }

    public function setStoredCredentials(RegisterObserver $user)
    {
        $_SESSION[self::$username] = $user->getRequestUsername();
        $_SESSION[self::$password] = $user->getRequestPassword();
        $_SESSION[self::$passwordRepeat] = $user->getRequestPasswordRepeat();
    }

    public function validateStoredCredentials()
    {
        $this->validator->validate($this);
        $_SESSION[self::$message] = $this->validator->getMessage();
    }

    public function filterUsername()
    {
        $_SESSION[self::$username] = filter_var($username, FILTER_SANITIZE_STRING);
    }

    public function getStoredUsername() : string
    {
        return ($this->isUsername()) ? $_SESSION[self::$username] : "";
    }

    public function getStoredPassword() : string
    {
        return $_SESSION[self::$password];
    }

    public function getStoredPasswordRepeat() : string
    {
        return $_SESSION[self::$passwordRepeat];
    }

    public function getStoredMessage() : string
    {
        return ($this->isMessage()) ? $_SESSION[self::$message] : "";
    }

    public function setStoredMessage(string $message)
    {
        $_SESSION[self::$message] = $message;
    }

    public function isUsername() : bool
    {
        return isset($_SESSION[self::$username]);
    }

    public function isMessage() : bool
    {
        return isset($_SESSION[self::$message]);
    }

    public function isErrors() : bool
    {
        return $_SESSION[self::$message] != \view\MessageView::RegisterSuccessful;
    }

    public function getUserFromDatabase(string $username) : \PDOStatement
    {
        assert(isset($username));

        return $this->dbHelper->findData(array(
        PDOService::PDO_USERNAME => $username
        ));
    }

    public function saveUserToDatabase(string $username, string $password)
    {
        assert(isset($username));
        assert(isset($password));

        $this->userData = $this->dbHelper->saveData(array(
        PDOService::PDO_USERNAME => $username,
        PDOService::PDO_PASSWORD => $password
        ));
    }
}
