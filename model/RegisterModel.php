<?php

namespace model;

require_once("PersistantUser.php");
require_once("Validator.php");

class RegisterModel
{

    private $username;
    private $password;

    public function __construct()
    {
        $this->persistentUser = new PersistantUser();
    }

    public function newRegister(RegisterObserver $observer)
    {
        $this->setRegisterCredentials($observer);
        $this->setPersistentUser($observer);
        $this->executeRegister($observer);
    }

    private function setRegisterCredentials(RegisterObserver $view)
    {
        $this->username = $view->getRequestUsername();
        $this->password = $this->hashString($view->getRequestPassword());
    }

    private function setPersistentUser(RegisterObserver $view)
    {
        $this->persistentUser->setStoredCredentials($view);
        $this->persistentUser->validateStoredCredentials();
    }

    public function executeRegister(RegisterObserver $view)
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

    public function handleError(RegisterObserver $view)
    {
        $view->setLastUsernameInput($this->persistentUser->getStoredUsername());
        $view->setRequestMessage($this->persistentUser->getStoredMessage());
    }
}
