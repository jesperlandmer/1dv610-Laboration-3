<?php

namespace model;

class PersistantUser
{
    private static $username = "PersistantUser::Username";
    private static $password = "PersistantUser::Password";
    private static $passwordRepeat = "PersistantUser::PasswordRepeat";
    private static $message = "PersistantUser::Message";

    public function __construct()
    {
        assert(isset($_SESSION));
        $this->validator = new Validator();
    }

    /**
     * @return void
     */
    public function newRegister(RegisterModel $user)
    {
        $this->validator->validate($user);

        $_SESSION[self::$username] = $user->getUsername();
        $_SESSION[self::$password] = $user->getPassword();
        $_SESSION[self::$passwordRepeat] = $user->getPasswordRepeat();
        $_SESSION[self::$message] = $this->validator->getMessage();
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
    public function getMessage()
    {
        if ($this->isMessage()) {
            return $_SESSION[self::$message];
        }
    }
    /**
     * @return boolean
     */
    public function isMessage()
    {
        return isset($_SESSION[self::$message]);
    }
    /**
     * @return boolean
     */
    public function isErrors()
    {
        return $_SESSION[self::$message] != \view\MessageView::RegisterSuccessful;
    }
}
