<?php

namespace controller;

require_once(__DIR__ . '/../model/LoginModel.php');
require_once(__DIR__ . '/../view/LoginView.php');

class LoginController {

	public function __construct() {
		$this->loginModel = new \model\LoginModel();
		$this->loginView = new \view\LoginView($this->loginModel);

		if (strlen($this->loginModel->getStoredUsername()) > 0) {
			$this->loginView->setRequestUsername($this->loginModel->getStoredUsername());
		}
		$this->loginView->setRequestMessage($this->loginModel->getStoredMessage());

		if ($this->loginView->isLogin()) {
			$this->loginModel->newLogin($this->loginView);
		}

		if ($this->loginView->isLogOut() && $this->loginView->isCookieCredentials()) {
			$this->loginModel->executeLogout($this->loginView);
		}
	}

	public function showLoginPage(bool $loginStatus) : string
	{
		return $this->loginView->showResponse($loginStatus);
	}

	public function getLoginStatus() : bool
	{
		if ($this->loginView->isCookieCredentials()) {
			return ($this->loginView->isCookieCredentialsCorrect()) ? true : false;
		} else {
			return false;
		}
	}
}