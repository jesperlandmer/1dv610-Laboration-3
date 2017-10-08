<?php

namespace view;

require_once('LoginView.php');
require_once('RegisterView.php');
require_once('DateTimeView.php');

class LayoutView {

  public function __construct() 
  {
    $this->loginView = new LoginView();
    $this->registerView = new RegisterView();
    $this->dateTimeView = new DateTimeView();
  }
  
  public function render($isLoggedIn) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $this->loginView->response() . '
              
              ' . $this->dateTimeView->showDateTimeFormat() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
