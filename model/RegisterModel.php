<?php

namespace model;

require_once("PersistantUser.php");
require_once("DatabaseModel.php");

class RegisterModel
{
    private $username;
    private $password;
    private $registerObserver;

    public function __construct()
    {
        $this->persistentUser = new PersistantUser();
        $this->dbModel = new DatabaseModel();
    }

    public function newRegister(RegisterObserver $observer)
    {
        $this->registerObserver = $observer;
        $this->setNecessaryCredentials();
        $this->executeRegister();
    }

    private function setNecessaryCredentials() 
    {
      $this->setRegisterCredentials();
      $this->setPersistentUser();
    }

    private function setRegisterCredentials()
    {
        $this->username = $this->registerObserver->getRequestUsername();
        $this->password = $this->registerObserver->getRequestPassword();
    }

    private function setPersistentUser()
    {
        $this->persistentUser->setRegisterCredentials($this->registerObserver);
        $this->persistentUser->validateRegisterCredentials();
    }

    public function executeRegister()
    {
        if ($this->persistentUser->isErrors() == false) {
            $this->registerSuccessful();
        } else {
            $this->doErrorHandling();
        }
    }

    private function registerSuccessful()
    {
        $this->dbModel->saveUserToDatabase($this->username, $this->password);
        $this->persistentUser->setStoredMessage(\view\MessageView::RegisterSuccessful);
        $this->registerObserver->redirectToHomePage();
    }

    private function doErrorHandling()
    {
        $this->registerObserver->setLastUsernameInput($this->persistentUser->getStoredUsername());
        $this->registerObserver->setRequestMessage($this->persistentUser->getStoredMessage());
    }
}
