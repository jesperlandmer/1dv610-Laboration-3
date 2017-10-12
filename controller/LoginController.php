<?php

namespace controller;

require_once(__DIR__ . '/../model/LoginModel.php');
require_once(__DIR__ . '/../view/LoginView.php');

class LoginController {

	public function __construct() {
		$this->loginModel = new \model\LoginModel();
		$this->loginView = new \view\LoginView($this->loginModel);

		if ($this->loginView->isLogin()) {
			$this->doLogin();
		} else if ($this->isLogout()) {
			$this->doLogout();
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
		if ($this->loginView->isCookieCredentials() && $this->loginView->isCookieCredentialsCorrect()) {
			return ($this->loginView->isCookieCredentialsCorrect()) ? true : false;
		} else {
			return false;
		}
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

	private function doLogin() 
	{
		$this->loginModel->newLogin($this->loginView);
	}

	private function doLogout() 
	{
		$this->loginModel->executeLogout($this->loginView);
	}

	private function isLogout()
	{
		return ($this->loginView->isLogOut() && $this->loginView->isCookieCredentials());
	}
}