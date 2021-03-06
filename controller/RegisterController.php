<?php

namespace controller;

require_once(__DIR__ . '/../model/RegisterModel.php');
require_once(__DIR__ . '/../view/RegisterView.php');

class RegisterController {

	public function __construct() 
	{
		$this->user = new \model\RegisterModel();
		$this->registerView = new \view\RegisterView();

		if ($this->registerView->isRequestRegister()) {
			$this->user->newRegister($this->registerView);
		}
	}

	public function showRegisterPage(bool $loginStatus) : string
	{
		return $this->registerView->showResponse($loginStatus);
	}
}