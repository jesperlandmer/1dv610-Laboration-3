<?php

namespace model;

require_once("PersistantUser.php");
require_once("Validator.php");

class RegisterModel
{

    private $username;
    private $password;
    private $registerObserver;

    public function __construct()
    {
        $this->persistentUser = new PersistantUser();
    }

    public function newRegister(RegisterObserver $observer)
    {
        $this->registerObserver = $observer;
        $this->setRegisterCredentials();
        $this->setPersistentUser();
        $this->executeRegister();
    }

    private function setRegisterCredentials()
    {
        $this->username = $this->registerObserver->getRequestUsername();
        $this->password = $this->getHashedPassword();
    }

    private function setPersistentUser()
    {
        $this->persistentUser->setRegisterCredentials($this->registerObserver);
        $this->persistentUser->validateRegisterCredentials();
    }

    public function executeRegister()
    {
        if ($this->persistentUser->isErrors() == false) {
            $this->persistentUser->saveUserToDatabase($this->username, $this->password);
            $this->registerObserver->redirectToHomePage();
        } else {
            $this->handleError();
        }
    }

    private function getHashedPassword() : string
    {
        $password = $this->registerObserver->getRequestPassword();
        return password_hash("$password", PASSWORD_BCRYPT, ["cost" => 8]);
    }

    public function handleError()
    {
        $this->registerObserver->setLastUsernameInput($this->persistentUser->getStoredUsername());
        $this->registerObserver->setRequestMessage($this->persistentUser->getStoredMessage());
    }
}
