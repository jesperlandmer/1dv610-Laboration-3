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

    public function validate(User $user) 
    {
      $this->user = $user;
      
            if ($this->usernameHasMinLength() == false) {
              $this->errorMessage .= self::$errorUsernameLength . "<br>";
            }
      
            if ($this->passwordHasMinLength() == false) {
              $this->errorMessage .= self::$errorPasswordLength . "<br>";
            }
      
            if ($this->inputIsValidFormat() == false) {
              $this->errorMessage .= self::$errorInvalidFormat . "<br>";
            }
      
            if ($this->isUniqueUsername() == false) {
              $this->errorMessage .= self::$errorUserExists . "<br>";
            }
      
            if ($this->repeatedPasswordMatch() == false) {
              $this->errorMessage .= self::$errorPasswordMatch;
            }
    }

    /**
     * @return boolean
     */
    public function usernameHasMinLength()
    {
        return strlen($this->user->getUsername()) >= 3;
    }

    /**
     * @return boolean
     */
    public function passwordHasMinLength()
    {
        return strlen($this->user->getPassword()) >= 6;
    }
    
    /**
     * @return boolean
     */
    public function inputIsValidFormat()
    {
        return filter_var($this->user->getUsername(), FILTER_SANITIZE_STRING) == $this->user->getUsername();
    }

    /**
     * @return boolean
     */
    public function isUniqueUsername()
    {
        return $this->user->getUserFromDatabase()->rowCount() == 0;
    }

    /**
     * @return boolean
     */
    public function repeatedPasswordMatch()
    {
        return $this->user->getPassword() == $this->user->getPasswordRepeat();
    }

    /**
     * @return boolean
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
