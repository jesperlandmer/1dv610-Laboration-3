<?php

namespace controller;

require_once(__DIR__ . '/../model/LoginModel.php');
require_once(__DIR__ . '/../view/LoginView.php');

class LoginController {

	public function __construct() {
		$this->loginModel = new \model\LoginModel();
		$this->loginView = new \view\LoginView($this->loginModel);

		if ($this->loginView->isLogin()) {
			$this->loginModel->newLogin($this->loginView);
		}

		if ($this->loginView->isLogOut()) {
			$this->loginView->clearCookies();
			$this->loginView->refreshPage();
		}
	}

	/**
     * @return string
     */
	public function showLoginPage()
	{
		return $this->loginView->showResponse();
	}
	/**
     * @return boolean
     */
	public function getLoginStatus()
	{
		return $this->loginView->isCookieLoggedInUser();
	}
}