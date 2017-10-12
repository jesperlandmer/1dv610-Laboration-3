<?php

namespace view;

require_once("MessageView.php");
require_once("DateTimeView.php");

class LayoutView {

  private $isLoggedIn = false;

  public function __construct(bool $loggedInStatus)
  {
    $this->isLoggedIn = $loggedInStatus;
    $this->messageView = new MessageView();
    $this->dateTimeView = new DateTimeView();
  }
  
  public function render($pageView)
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
          ' . $this->renderIsLoggedIn() . '
          
          <div class="container">
              ' . $pageView . '
              
              ' . $this->dateTimeView->showDateTimeFormat() . '
          </div>
         </body>
      </html>
    ';
  }

  private function renderTopLink() : string
  {
    return ($this->isRegisterPage()) ? "<a href='?'>Back to login</a>" : "<a href='?register'>Register a new user</a>";
  }
  
  private function renderIsLoggedIn() : string
  {
    return ($this->isLoggedIn) ? "<h2>Logged in</h2>" : "<h2>Not logged in</h2>";
  }

  public function isRegisterPage() : bool
  {
    return isset($_GET["register"]);
  }
}