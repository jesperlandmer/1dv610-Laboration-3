<?php

namespace controller;

require_once(__DIR__ . '/../model/EditModel.php');
require_once(__DIR__ . '/../view/EditView.php');

class EditController {

	public function __construct() 
	{
		$this->editModel = new \model\EditModel();
		$this->editView = new \view\EditView();

		if ($this->editView->isRequestEdit()) {
			$this->editModel->newChangePassword($this->editView);
		}
	}

	public function showEditPage(bool $loginStatus) : string
	{
		return $this->editView->showResponse($loginStatus);
	}
}