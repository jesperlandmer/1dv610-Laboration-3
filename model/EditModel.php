<?php

namespace model;

require_once("PersistantUser.php");
require_once("DatabaseModel.php");

class EditModel 
{
    private $newPassword;
    private $observer;

    public function __construct()
    {
        $this->persistentUser = new PersistantUser();
        $this->dbModel = new DatabaseModel();
    }

    public function newChangePassword(EditObserver $observer)
    {
        $this->editObserver = $observer;
        $this->setNecessaryCredentials();
        $this->executeEdit();
    }

    private function setNecessaryCredentials()
    {
        $this->setEditCredentials();
        $this->setPersistentUser();
    }

    private function setEditCredentials()
    {
        $this->username = $this->editObserver->getCookieUsername();
        $this->password = $this->editObserver->getRequestCurrentPassword();
        $this->newPassword = $this->editObserver->getRequestPassword();
    }

    private function setPersistentUser()
    {
        $this->persistentUser->setEditCredentials($this->editObserver);
        $this->persistentUser->validateEditCredentials();
    }

    private function executeEdit()
    {
         if ($this->persistentUser->isErrors() == true) {

            $this->doErrorPasswordValidation();
        } elseif ($this->dbModel->isExistingUser($this->username, $this->password) == false) {
            
            $this->doErrorWrongCurrentPassword();
        } else {
        
            $this->editSuccessful();
        }
    }

    private function doErrorWrongCurrentPassword()
    {
        $this->editObserver->setRequestMessage(\view\MessageView::ErrorCurrentPassword);
    }

    private function doErrorPasswordValidation()
    {
        $this->editObserver->setRequestMessage($this->persistentUser->getStoredMessage());
    }

    private function editSuccessful()
    {
        $this->updateCredentials();
        $this->persistentUser->setStoredMessage(\view\MessageView::ChangePasswordSuccessful);
        $this->editObserver->redirectToHomePage();
    }

    private function updateCredentials()
    {
        $this->dbModel->updateUserFromDatabase($this->username, $this->newPassword);
        $this->editObserver->setCookiePassword($this->newPassword);   
    }
}
