<?php

namespace model;

require_once("PersistantUser.php");
require_once("Validator.php");

class EditModel
{
    private $currentPassword;
    private $password;
    private $passwordRepeat;
    private $editObserver;

    public function __construct()
    {
        $this->persistentUser = new PersistantUser();
    }

    public function newChangePassword(EditObserver $editObserver)
    {
        $this->setEditCredentials();
        $this->setPersistentUser();
        $this->executeRegister();
    }

    private function setChangePasswordCredentials()
    {
        $this->currentPassword = $this->editObserver->getRequestCurrentPassword();
        $this->password = $this->editObserver->getRequestPassword();
        $this->passwordRepeat = $this->editObserver->getRequestPasswordRepeat();
    }

    private function setPersistentUser()
    {
        $this->persistentUser->setChangePasswordCredentials($this->editObserver);
        $this->persistentUser->validateChangePasswordCredentials();
    }

    public function executeEdit()
    {
        if ($this->persistentUser->isErrors() == false) {
            $this->persistentUser->updateUserFromDatabase($this->username, $this->password);
            $this->editObserver->redirectToHomePage();
        } else {
            $this->handleError();
        }
    }

    private function getHashedPassword() : string
    {
        $password = $this->editObserver->getRequestPassword();
        return password_hash("$password", PASSWORD_BCRYPT, ["cost" => 8]);
    }

    public function handleError()
    {
        $this->editObserver->setLastUsernameInput($this->persistentUser->getStoredUsername());
        $this->editObserver->setRequestMessage($this->persistentUser->getStoredMessage());
    }
}
