<?php

namespace model;

require_once("PersistantUser.php");

class Validator
{
    private $errorMessage;

    private static $errorUsernameLength = "Username has too few characters, at least 3 characters.";
    private static $errorPasswordLength = "Username has too few characters, at least 3 characters.";
    private static $errorPasswordMatch = "Passwords do not match.";
    private static $errorUserExists = "User exists, pick another username.";
    private static $errorInvalidFormat = "Username contains invalid characters.";
    private static $errorNoUserFound = "Wrong name or password";

    public function __construct(PersistantUser $user)
    {
      if ($user->usernameHasMinLength() == false) {
        $this->errorMessage .= self::$errorUsernameLength;
      }

      if ($user->passwordHasMinLength() == false) {
        $this->errorMessage .= self::$errorPasswordLength;
      }

      if ($user->inputIsValidFormat() == false) {
        $this->errorMessage .= self::$errorInvalidFormat;
      }

      if ($user->usernameExists() == false) {
        $this->errorMessage .= self::$errorUserExists;
      }

      if ($user->repeatedPasswordMatch() == false) {
        $this->errorMessage .= self::$errorPasswordMatch;
      }

      $user->setErrorMessage($this->errorMessage);
    }
}
