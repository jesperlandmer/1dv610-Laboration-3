<?php

namespace model;

require_once("PersistantUser.php");

class LoginModel
{

    private $username;
    private $password;
    private $loginObserver;

    public function __construct()
    {
        $this->persistentUser = new PersistantUser();
    }

    public function newLogin(LoginObserver $observer)
    {
        $this->loginObserver = $observer;
        $this->setLoginCredentials();
        $this->executeLogin();
    }

    public function newLogout(LoginObserver $observer)
    {
        $observer->clearCookieCredentials();
        $this->persistentUser->setStoredMessage(\view\MessageView::LogoutSuccessful);
        $observer->refreshPage();
    }

    public function isLoggedInWithCookies(string $username, string $password) : bool
    {
        $this->username = $username;
        $this->password = $password;

        return $this->isExistingUser();
    }

    public function setLoginCredentials()
    {
        $this->username = $this->loginObserver->getRequestUsername();
        $this->password = $this->loginObserver->getRequestPassword();
    }

    private function executeLogin()
    {
        if ($this->isUsernameInput() == false) {

            $this->loginObserver->setRequestMessage(\view\MessageView::ErrorNoUserNameInput);
        } elseif ($this->isPasswordInput() == false) {

            $this->loginObserver->setRequestMessage(\view\MessageView::ErrorNoPasswordInput);
        } elseif ($this->isExistingUser() == false) {

            $this->loginObserver->setLastUsernameInput($this->username);
            $this->loginObserver->setRequestMessage(\view\MessageView::ErrorNoUserFound);
        } elseif ($this->loginObserver->isCookieCredentials() == false) {

            $this->loginObserver->setCookieCredentials($this->username, $this->password);
            $this->persistentUser->setStoredMessage(\view\MessageView::LoginSuccessful);
            $this->loginObserver->refreshPage();
        }
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
        return password_verify($this->password, $this->getDBUserPassword());
    }

    private function getDBUserPassword() : string
    {
        return $this->persistentUser->getUserFromDatabase($this->username)->fetch()[PDOVariables::DB_PASSWORD_COLUMN];
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
