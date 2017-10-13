<?php

namespace controller;

require_once(__DIR__ . '/../model/LoginModel.php');
require_once(__DIR__ . '/../view/LoginView.php');

class LogoutController
{

    public function __construct()
    {
        $this->loginModel = new \model\LoginModel();
        $this->loginView = new \view\LoginView();
        
		if ($this->isLogout()) {
            $this->loginModel->newLogout($this->loginView);
        }
    }

    private function isLogout() : bool
    {
        return ($this->loginView->isRequestLogout() && $this->loginView->isCookieCredentials());
    }
}
