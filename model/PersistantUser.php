<?php

namespace model;

require_once("Validator.php");

class PersistantUser
{
    private static $username = "PersistantUser::Username";
    private static $password = "PersistantUser::Password";
    private static $passwordRepeat = "PersistantUser::PasswordRepeat";
    private static $currentPassword = "PersistantUser::CurrentPassword";
    private static $message = "PersistantUser::Message";

    public function __construct()
    {
        assert(isset($_SESSION));

        $this->validator = new Validator();
    }

    public function setRegisterCredentials(RegisterObserver $user)
    {
        $_SESSION[self::$username] = $user->getRequestUsername();
        $_SESSION[self::$password] = $user->getRequestPassword();
        $_SESSION[self::$passwordRepeat] = $user->getRequestPasswordRepeat();
    }

    public function setEditCredentials(EditObserver $user)
    {
        $_SESSION[self::$currentPassword] = $user->getRequestCurrentPassword();
        $_SESSION[self::$password] = $user->getRequestPassword();
        $_SESSION[self::$passwordRepeat] = $user->getRequestPasswordRepeat();
    }

    public function validateRegisterCredentials()
    {
        $this->validator->validateNewUser($this);
        $_SESSION[self::$message] = $this->validator->getMessage();
    }

    public function validateEditCredentials()
    {
        $this->validator->validateNewPassword($this);
        $_SESSION[self::$message] = $this->validator->getMessage();
    }

    public function filterUsername(string $username)
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
        return ($this->isErrors()) ? $_SESSION[self::$message] : "";
    }

    public function setStoredMessage(string $message)
    {
        $_SESSION[self::$message] = $message;
    }

    public function isUsername() : bool
    {
        return isset($_SESSION[self::$username]);
    }

    public function isErrors() : bool
    {
        return (isset($_SESSION[self::$message]) && strlen($_SESSION[self::$message]) > 0);
    }
}
