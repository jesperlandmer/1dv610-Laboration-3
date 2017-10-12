<?php

namespace model;

require_once("PersistantUser.php");
require_once("Validator.php");

class RegisterModel
{

    private $username;
    private $password;
    private $passwordRepeat;

    public function __construct()
    {
        $this->persistentUser = new PersistantUser();
    }

    public function newRegister(RegisterObserver $observer) : void
    {
        $this->setRegisterCredentials($observer);
        $this->persistentUser->setStoredCredentials($observer);
        $this->persistentUser->validateStoredCredentials();
        $this->executeRegister($observer);
    }

    public function setRegisterCredentials(RegisterObserver $view) : void
    {
        $this->username = $view->getRequestUsername();
        $this->password = $this->hashString($view->getRequestPassword());
    }

    public function executeRegister(RegisterObserver $view) : void
    {
        if ($this->persistentUser->isErrors() == false) {
            $this->persistentUser->saveUserToDatabase($this->username, $this->password);
            $view->redirectToHomePage();
        } else {
            $this->handleError($view);
        }
    }

    private function hashString(string $input) : string
    {
        return password_hash("$input", PASSWORD_BCRYPT, ["cost" => 8]);
    }

    public function handleError(RegisterObserver $view) : void
    {
        $view->setLastUsernameInput($this->persistentUser->getStoredUsername());
        $view->setRequestMessage($this->persistentUser->getStoredMessage());
    }
}
