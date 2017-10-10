<?php

namespace model;

require_once("PersistantUser.php");

class Validator
{
    private $message;

    public function validate(RegisterModel $user) 
    {
      $this->user = $user;
      
            if ($this->usernameHasMinLength() == false) {
              $this->message .= \view\MessageView::ErrorUsernameLength;
            }
      
            if ($this->passwordHasMinLength() == false) {
              $this->message .= \view\MessageView::ErrorPasswordLength;
            }
      
            if ($this->inputIsValidFormat() == false) {
              $this->message .= \view\MessageView::ErrorInvalidFormat;
            }
      
            if ($this->isUniqueUsername() == false) {
              $this->message .= \view\MessageView::ErrorUserExists;
            }
      
            if ($this->repeatedPasswordMatch() == false) {
              $this->message .= \view\MessageView::ErrorPasswordMatch;
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
    public function isMessage()
    {
        return isset($this->message);
    }
    /**
     * @return string
     */
    public function getMessage()
    {
        if ($this->isMessage()) {
            return $this->message;
        } else {
            return \view\MessageView::RegisterSuccessful;
        }
    }
}
