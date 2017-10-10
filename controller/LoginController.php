<?php

namespace controller;

require_once(__DIR__ . '/../model/LoginModel.php');
require_once(__DIR__ . '/../view/LoginView.php');

class LoginController {

	public function __construct() {
		$this->loginView = new \view\LoginView();

		if ($this->loginView->isLogin()) {
			$this->user = new \model\LoginModel();
		}
	}

	public function showLoginPage()
	{
		return $this->loginView->response();
	}
}