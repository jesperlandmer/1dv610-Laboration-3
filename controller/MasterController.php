<?php

namespace controller;

require_once(__DIR__ . '/../view/LayoutView.php');
require_once('RegisterController.php');
require_once('LoginController.php');

class MasterController {

    public function __construct() 
    {
        $this->registerController = new \controller\RegisterController();
        $this->loginController = new \controller\LoginController();
        $this->layoutView = new \view\LayoutView($this->loginController->getLoginStatus());
    }
    
    public function showPage()
    {
        if ($this->layoutView->isRegisterPage()) {
            $this->layoutView->render($this->getRegisterPage());
        } else {
            $this->layoutView->render($this->getLoginPage());
        }
    }

    private function getRegisterPage() : string
    {
        return $this->registerController->showRegisterPage($this->loginController->getLoginStatus());
    }

    private function getLoginPage() : string
    {
        return $this->loginController->showLoginPage($this->loginController->getLoginStatus());
    }
}