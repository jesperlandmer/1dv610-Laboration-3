<?php

namespace controller;

require_once(__DIR__ . '/../model/LoginModel.php');
require_once(__DIR__ . '/../view/LoginView.php');

class LoginController
{

    public function __construct()
    {
        $this->loginModel = new \model\LoginModel();
		$this->loginView = new \view\LoginView();
		
		if ($this->loginView->isRequestLogin()) {
        	$this->loginModel->newLogin($this->loginView);
        }
    }

    public function showLoginPage(bool $loginStatus) : string
    {
        $this->setStoredUsername();
        $this->setStoredMessage();
        return $this->loginView->showResponse($loginStatus);
    }

    public function getLoginStatus() : bool
    {
        if ($this->loginView->isCookieCredentials()) {
            return $this->checkCookieLoginStatus();
        }
        return false;
    }

    private function checkCookieLoginStatus() : bool
    {
        return $this->loginModel->isCorrectUserCredentials($this->loginView->getCookieUsername(),
        $this->loginView->getCookiePassword());
    }

    private function setStoredUsername()
    {
        if (strlen($this->loginModel->getStoredUsername()) > 0) {
            $this->loginView->setRequestUsername($this->loginModel->getStoredUsername());
        }
    }

    private function setStoredMessage()
    {
        if (strlen($this->loginModel->getStoredMessage()) > 0) {
            $this->loginView->setRequestMessage($this->loginModel->getStoredMessage());
        }
    }
}
