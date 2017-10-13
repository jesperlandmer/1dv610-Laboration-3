<?php

namespace model;

require_once("PersistantUser.php");
require_once("DatabaseModel.php");

class LoginModel
{

    private $username;
    private $password;
    private $loginObserver;

    public function __construct()
    {
        $this->persistentUser = new PersistantUser();
        $this->dbModel = new DatabaseModel();
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

    private function setLoginCredentials()
    {
        $this->username = $this->loginObserver->getRequestUsername();
        $this->password = $this->loginObserver->getRequestPassword();
    }

    private function executeLogin()
    {
        if ($this->isUsernameInput() == false) {

            $this->doErrorNoUsername();
        } elseif ($this->isPasswordInput() == false) {

            $this->doErrorNoPassword();
        } elseif ($this->dbModel->isExistingUser($this->username, $this->password) == false) {

            $this->doErrorWrongCredentials();
        } elseif ($this->loginObserver->isCookieCredentials() == false) {

            $this->loginSuccessful();
        }
    }

    private function doErrorNoUsername()
    {
      $this->loginObserver->setRequestMessage(\view\MessageView::ErrorNoUserNameInput);
    }

    private function doErrorNoPassword()
    {
      $this->loginObserver->setRequestMessage(\view\MessageView::ErrorNoPasswordInput);
    }

    private function doErrorWrongCredentials()
    {
        $this->loginObserver->setLastUsernameInput($this->username);
        $this->loginObserver->setRequestMessage(\view\MessageView::ErrorNoUserFound);
    }

    private function doErrorWrongInfoInCookies()
    {
        $this->loginObserver->setRequestMessage(\view\MessageView::ErrorCookieInfo);
    }

    private function loginSuccessful()
    {
        $this->loginObserver->setCookieCredentials($this->username, $this->password);
        $this->persistentUser->setStoredMessage(\view\MessageView::LoginSuccessful);
        $this->loginObserver->refreshPage();
    }

    private function isUsernameInput() : bool
    {
        return strlen($this->username) > 0;
    }

    private function isPasswordInput() : bool
    {
        return strlen($this->password) > 0;
    }

    public function getStoredUsername() : string
    {
        return $this->persistentUser->getStoredUsername();
    }

    public function getStoredMessage() : string
    {
        return $this->persistentUser->getStoredMessage();
    }

    public function isCorrectUserCredentials(LoginObserver $observer) : bool
    {
        $this->loginObserver = $observer;
        return $this->isCorrectInfoInCookie();
    }

    private function isCorrectInfoInCookie()
    {
      $username = $this->loginObserver->getCookieUsername();
      $password = $this->loginObserver->getCookiePassword();

      if ($this->dbModel->isExistingUser($username, $password)) {
        return true;
      }
      $this->doErrorWrongInfoInCookies();
      return false;
    }
}
