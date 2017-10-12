<?php

namespace model;

require_once("PersistantUser.php");

class LoginModel
{

    private $username;
    private $password;

    public function __construct()
    {
        $this->persistentUser = new PersistantUser();
    }

    public function newLogin(LoginObserver $observer) : void
    {
        $this->setLoginCredentials($observer);
        $this->executeLogin($observer);
    }

    public function isLoggedIn(string $username, string $password) : bool
    {
        $this->username = $username;
        $this->password = $password;

        return $this->isExistingUser();
    }

    public function setLoginCredentials(LoginObserver $input) : void
    {
        $this->username = $input->getRequestUsername();
        $this->password = $input->getRequestPassword();
    }

    private function executeLogin(LoginObserver $view) : void
    {
        if ($this->isUsernameInput() == false) {
            $view->setRequestMessage(\view\MessageView::ErrorNoUserNameInput);
        } elseif ($this->isPasswordInput() == false) {
            $view->setRequestMessage(\view\MessageView::ErrorNoPasswordInput);
        } elseif ($this->isExistingUser() == false) {
            $view->setLastUsernameInput($this->username);
            $view->setRequestMessage(\view\MessageView::ErrorNoUserFound);
        } else {
            $view->setCookieCredentials($this->username, $this->password);
            $this->persistentUser->setStoredMessage(\view\MessageView::LoginSuccessful);
            $view->refreshPage();
        }
    }

    public function executeLogout(LoginObserver $view) : void
    {
        $view->clearCookieCredentials();
        $this->persistentUser->setStoredMessage(\view\MessageView::LogoutSuccessful);
        $view->refreshPage();
    }

    private function isUsernameInput() : bool
    {
        return strlen($this->username) > 0;
    }

    private function isPasswordInput() : bool
    {
        return strlen($this->password) > 0;
    }

    private function isExistingUser() : bool
    {
        $user = $this->persistentUser->getUserFromDatabase($this->username);
        return password_verify($this->password, $user->fetch()[PDOService::PDO_PASSWORD]);
    }

    public function getStoredUsername() : string
    {
        return $this->persistentUser->getStoredUsername();
    }
    public function getStoredMessage() : string
    {
        return $this->persistentUser->getStoredMessage();
    }
}
