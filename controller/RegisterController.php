<?php

namespace controller;

require_once(__DIR__ . '/../model/RegisterModel.php');
require_once(__DIR__ . '/../view/RegisterView.php');

class RegisterController {

	public function __construct() 
	{
		$this->registerView = new \view\RegisterView();

		if ($this->registerView->isRegister()) {
			$this->user = new \model\RegisterModel();
			$this->user->newRegister($this->registerView);
		}
	}

	public function showRegisterPage()
	{
		return $this->registerView->response();
	}
}