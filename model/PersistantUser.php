<?php

namespace model;

class PersistantUser
{
    private static $username = "PersistantUser::username";
    private static $password = "PersistantUser::password";
    private static $passwordRepeat = "PersistantUser::passwordRepeat";
    private static $errorMessage = "PersistantUser::errorMessage";

    public function __construct(string $inputUsername, string $inputPassword, string $inputPasswordRepeat)
    {
        assert(isset($_SESSION));
        session_unset();

        $this->newRegister($inputUsername, $inputPassword, $inputPasswordRepeat);
    }

    /**
     * @return void
     */
    public function newRegister(string $username, string $password, string $passwordRepeat)
    {
        $_SESSION[self::$username] = $username;
        $_SESSION[self::$password] = $password;
        $_SESSION[self::$passwordRepeat] = $passwordRepeat;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $_SESSION[self::$username];
    }

    /**
     * @return void
     */
    public function setErrorMessage($message)
    {
        if (isset($message) == true) {
            $_SESSION[self::$errorMessage] = $message;
        }
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        if ($this->isErrors()) {
            return $_SESSION[self::$errorMessage];
        } else {
            return "";
        }
    }

    /**
     * @return boolean
     */
    public function isErrors()
    {
        return isset($_SESSION[self::$errorMessage]);
    }

    /**
     * @return boolean
     */
    public function usernameHasMinLength()
    {
        return strlen($_SESSION[self::$username]) >= 3;
    }

    /**
     * @return boolean
     */
    public function passwordHasMinLength()
    {
        return strlen($_SESSION[self::$password]) >= 6;
    }
    
    /**
     * @return boolean
     */
    public function inputIsValidFormat()
    {
        return filter_var($_SESSION[self::$username], FILTER_SANITIZE_STRING) == $_SESSION[self::$username];
    }

    /**
     * @return boolean
     */
    public static function repeatedPasswordMatch()
    {
        return $_SESSION[self::$password] == $_SESSION[self::$passwordRepeat];
    }
}
