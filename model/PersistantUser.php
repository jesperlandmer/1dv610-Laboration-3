<?php

namespace model;

class PersistantUser
{
    private static $username = "PersistantUser::username";
    private static $password = "PersistantUser::password";
    private static $passwordRepeat = "PersistantUser::passwordRepeat";
    private static $errorMessage = "PersistantUser::errorMessage";

    public function __construct()
    {
        assert(isset($_SESSION));
        session_unset();

        $this->validator = new Validator();
    }

    /**
     * @return void
     */
    public function newRegister(User $user)
    {
        $this->validator->validate($user);

        $_SESSION[self::$username] = $user->getUsername();
        $_SESSION[self::$password] = $user->getPassword();
        $_SESSION[self::$passwordRepeat] = $user->getPasswordRepeat();
        $this->setErrorMessage($this->validator->getErrorMessage());
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $_SESSION[self::$username];
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
     * @return void
     */
    public function setErrorMessage($message)
    {
        if (isset($message) == true) {
            $_SESSION[self::$errorMessage] = $message;
        }
    }
    /**
     * @return boolean
     */
    public function isErrors()
    {
        return isset($_SESSION[self::$errorMessage]);
    }
}
