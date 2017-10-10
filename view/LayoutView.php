<?php

namespace view;

require_once("MessageView.php");
require_once("DateTimeView.php");

class LayoutView {

  private $isLoggedIn = false;

  public function __construct() 
  {
    new MessageView();
    $this->dateTimeView = new DateTimeView();
  }
  
  public function render($formResponse) 
  {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderTopLink() . '
          ' . $this->renderIsLoggedIn(false) . '
          
          <div class="container">
              ' . $formResponse . '
              
              ' . $this->dateTimeView->showDateTimeFormat() . '
          </div>
         </body>
      </html>
    ';
  }

  /**
	 * @return boolean
	 */
  public function isRegisterPage() 
  {
    return isset($_GET["register"]);
  }

  /**
	 * @return string
	 */
  private function renderTopLink() 
  {
    if ($this->isRegisterPage()) {
      return '<a href="?">Back to login</a>';
    } else {
      return '<a href="?register">Register a new user</a>';
    }
  }
  
  /**
	 * @return string
	 */
  private function renderIsLoggedIn($isLoggedIn) 
  {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
