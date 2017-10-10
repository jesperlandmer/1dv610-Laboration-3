<?php

namespace controller;

require_once(__DIR__ . '/../model/LoginModel.php');
require_once(__DIR__ . '/../view/LoginView.php');

class LoginController {

	public function __construct() {
		$this->loginView = new \view\LoginView();
		$this->loginModel = new \model\LoginModel();

		if ($this->loginView->isLogin()) {
			$this->poopi = new \model\LoginModel();
		}
	}

	/**
     * @return string
     */
	public function showLoginPage()
	{
		return $this->loginView->response($this->getStoredMessage());
	}

	/**
     * @return boolean
     */
	private function isStoredMessage()
	{
		return $this->loginModel->getStoredMessage() != null;
	}
	/**
     * @return string
     */
	private function getStoredMessage()
	{
		if ($this->isStoredMessage()) {
			return $this->loginModel->getStoredMessage();
		} else {
			return "";
		}
	}
}