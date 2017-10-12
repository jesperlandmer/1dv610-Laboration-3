<?php

namespace controller;

require_once(__DIR__ . '/../view/EditView.php');

class EditController {

	public function __construct() {
		$this->editView = new \view\EditView();

		if ($this->editView->isRequestEdit()) {
			// TODO: change password in model
			echo "Do change password";
		}
	}

	public function showEditPage(bool $loginStatus) : string
	{
		return $this->editView->showResponse($loginStatus);
	}
}