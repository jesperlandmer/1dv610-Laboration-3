<?php

namespace model;

require_once("PersistantUser.php");

class Validator
{
    private $errorMessage;

    private static $errorUsernameLength = "Username has too few characters, at least 3 characters.";
    private static $errorPasswordLength = "Password has too few characters, at least 6 characters.";
    private static $errorPasswordMatch = "Passwords do not match.";
    private static $errorUserExists = "User exists, pick another username.";
    private static $errorInvalidFormat = "Username contains invalid characters.";
    private static $errorNoUserFound = "Wrong name or password";

    public function __construct(PersistantUser $user, \PDOStatement $dbResult)
    {

      if ($user->usernameHasMinLength() == false) {
        $this->errorMessage .= self::$errorUsernameLength . "<br>";
      }

      if ($user->passwordHasMinLength() == false) {
        $this->errorMessage .= self::$errorPasswordLength . "<br>";
      }

      if ($user->inputIsValidFormat() == false) {
        $this->errorMessage .= self::$errorInvalidFormat . "<br>";
      }

      if ($this->isUniqueUsername($dbResult) == false) {
        $this->errorMessage .= self::$errorUserExists . "<br>";
      }

      if ($user->repeatedPasswordMatch() == false) {
        $this->errorMessage .= self::$errorPasswordMatch;
      }

      $user->setErrorMessage($this->errorMessage);
    }

    /**
     * @return boolean
     */
    public function isUniqueUsername(\PDOStatement $dbResult)
    {
        return $dbResult->rowCount() == 0;
    }
}
