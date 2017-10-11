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

        $_SESSION[self::$username] = $this->filterString($user->getUsername());
        $_SESSION[self::$message] = $this->validator->getMessage();
    }

    /**
     * @return string
     */
    public function filterString(string $input)
    {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }
     /**
     * @return boolean
     */
    public function isUsername()
    {
        return isset($_SESSION[self::$username]);
    }
    /**
     * @return boolean
     */
    public function isMessage()
    {
        return isset($_SESSION[self::$message]);
    }
    /**
     * @return string
     */
    public function getUsername()
    {
        if ($this->isUsername()) {
            return $_SESSION[self::$username];
        }
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
     * @return string
     */
    public function setMessage(string $message)
    {
        $_SESSION[self::$message] = $message;
    }
    /**
     * @return boolean
     */
    public function isErrors()
    {
        return $_SESSION[self::$message] != \view\MessageView::RegisterSuccessful;
    }
}
