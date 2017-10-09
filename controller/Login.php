<?php

namespace controller;

require_once(__DIR__ . '/../model/User.php');
require_once(__DIR__ . '/../view/LoginView.php');

class Login {

	public function __construct() {
		$this->registerView = new \view\RegisterView();

		if ($this->registerView->isRegister()) {
			$this->user = new \model\User($this->registerView);
		}
	}
}