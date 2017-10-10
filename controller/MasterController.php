<?php

namespace controller;

require_once(__DIR__ . '/../view/LayoutView.php');
require_once('RegisterController.php');
require_once('LoginController.php');

class MasterController {

    public function __construct() 
    {
        $this->layoutView = new \view\LayoutView();
        $this->registerController = new \controller\RegisterController();
        $this->loginController = new \controller\LoginController();
    }
    
    /**
     * @return void
     */
    public function showPage() 
    {
        if ($this->layoutView->isRegisterPage()) {
            $this->layoutView->render($this->registerController->showRegisterPage());
        } else {
            $this->layoutView->render($this->loginController->showLoginPage());
        }
    }
}