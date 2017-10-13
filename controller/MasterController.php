<?php

namespace controller;

require_once(__DIR__ . '/../view/LayoutView.php');
require_once('RegisterController.php');
require_once('LoginController.php');
require_once('LogoutController.php');
require_once('EditController.php');

class MasterController {

    private $isLoggedIn = false;

    public function __construct() 
    {
        $this->registerController = new \controller\RegisterController();
        $this->loginController = new \controller\LoginController();
        $this->logoutController = new \controller\LogoutController();
        $this->editController = new \controller\EditController();
        $this->layoutView = new \view\LayoutView($this->loginController->getLoginStatus());

        $this->isLoggedIn = $this->loginController->getLoginStatus();
    }
    
    public function showPage()
    {
        if ($this->layoutView->isRegisterPage()) {
            $this->layoutView->render($this->getRegisterPage());

        } elseif ($this->layoutView->isChangePasswordPage()) {

            $this->layoutView->render($this->getEditPage());
        } else {
            
            $this->layoutView->render($this->getLoginPage());
        }
    }

    private function getRegisterPage() : string
    {
        return $this->registerController->showRegisterPage($this->isLoggedIn);
    }

    private function getEditPage() : string
    {
        return $this->editController->showEditPage($this->isLoggedIn);
    }

    private function getLoginPage() : string
    {
        return $this->loginController->showLoginPage($this->isLoggedIn);
    }
}