<?php

namespace controller;

require_once(__DIR__ . '/../model/User.php');
require_once(__DIR__ . '/../view/RegisterView.php');

class Register {

	public function __construct() {
		$this->registerView = new \view\RegisterView();

		if ($this->registerView->isRegister()) {
			$this->user = new \model\User();
			$this->user->newRegister($this->registerView);
		}
	}
}