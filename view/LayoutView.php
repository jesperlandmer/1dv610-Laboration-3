<?php

namespace view;

require_once(__DIR__ . '/../model/UserObserver.php');
require_once("LoginView.php");
require_once("RegisterView.php");
require_once("DateTimeView.php");

class LayoutView implements \model\UserObserver {

  private $isLoggedIn = false;

  public function __construct($loginStatus) 
  {
    $this->isLoggedIn = $loginStatus;
    $this->loginView = new LoginView();
    $this->registerView = new RegisterView();
    $this->dateTimeView = new DateTimeView();
  }
  
  public function render() {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderTopLink() . '
          ' . $this->renderIsLoggedIn($this->isLoggedIn) . '
          
          <div class="container">
              ' . $this->renderFormResponse() . '
              
              ' . $this->dateTimeView->showDateTimeFormat() . '
          </div>
         </body>
      </html>
    ';
  }

  /**
	 * @return boolean
	 */
  private function isRegisterPage() {
    return isset($_GET["register"]);
  }

  /**
	 * @return string
	 */
  private function renderTopLink() {
    if ($this->isRegisterPage()) {
      return '<a href="?">Back to login</a>';
    } else {
      return '<a href="?register">Register a new user</a>';
    }
  }
  
  /**
	 * @return string
	 */
  private function renderIsLoggedIn() {
    if ($this->isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  /**
	 * @return string HTML code
	 */
  private function renderFormResponse() {
    if ($this->isRegisterPage()) {
      return $this->registerView->response($this->isLoggedIn);
    } else {
      return $this->loginView->response($this->isLoggedIn);
    }
  }

	public function getRequestUserName(\model\PersistantUser $user) {
		return $user->getUsername();
  }

  public function getRequestErrors(\model\PersistantUser $user) {
		return $user->getErrorMessage();
  }
  
  public function getRegister(\model\PersistantUser $user) {
		return $user->getErrorMessage();
	}
}
