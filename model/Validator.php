<?php

namespace model;

require_once("DatabaseModel.php");

class Validator
{
    private $message;

    public function __construct()
    {
        $this->dbModel = new DatabaseModel();
    }

    public function validateNewUser(PersistantUser $persistentUser)
    {
        $this->user = $persistentUser;
      
        if ($this->usernameHasMinLength() == false) {
            $this->message .= \view\MessageView::ErrorUsernameLength;
        }
      
        if ($this->passwordHasMinLength() == false) {
            $this->message .= \view\MessageView::ErrorPasswordLength;
        }
      
        if ($this->inputIsValidFormat() == false) {
            $user->filterUsername($this->user->getStoredUsername());
            $this->message .= \view\MessageView::ErrorInvalidFormat;
        }
      
        if ($this->isUniqueUsername() == false) {
            $this->message .= \view\MessageView::ErrorUserExists;
        }
      
        if ($this->repeatedPasswordMatch() == false) {
            $this->message .= \view\MessageView::ErrorPasswordMatch;
        }
    }

    public function validateNewPassword(PersistantUser $persistentUser)
    {
        $this->user = $persistentUser;
      
        if ($this->passwordHasMinLength() == false) {
            $this->message .= \view\MessageView::ErrorPasswordLength;
        }
      
        if ($this->repeatedPasswordMatch() == false) {
            $this->message .= \view\MessageView::ErrorPasswordMatch;
        }
    }

    public function usernameHasMinLength() : bool
    {
        return strlen($this->user->getStoredUsername()) >= 3;
    }

    public function passwordHasMinLength() : bool
    {
        return strlen($this->user->getStoredPassword()) >= 6;
    }
    
    public function inputIsValidFormat() : bool
    {
        return filter_var($this->user->getStoredUsername(), FILTER_SANITIZE_STRING) == $this->user->getStoredUsername();
    }

    public function isUniqueUsername() : bool
    {
        $username = $this->user->getStoredUsername();
        return $this->dbModel->getUserFromDatabase($username)->rowCount() == 0;
    }

    public function repeatedPasswordMatch() : bool
    {
        return $this->user->getStoredPassword() == $this->user->getStoredPasswordRepeat();
    }

    public function isMessage() : bool
    {
        return isset($this->message);
    }

    public function getMessage() : string
    {
        return ($this->isMessage()) ? $this->message : "";
    }
}
