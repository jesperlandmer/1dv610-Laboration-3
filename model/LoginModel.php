<?php

namespace model;

require_once("dbHelpers/PDOService.php");

class LoginModel {

  private $username;
  private $password;

  public function __construct() 
  {
    $this->dbHelper = new PDOService();
  }

  /**
   * @return void
   */
  public function newLogin(LoginObserver $observer) 
  {
    $this->setLoginCredentials($observer);
    $this->persistentUser->newLogin($this);
    $this->executeLogin($observer);
  }
  /**
   * @return void
   */
  public function setLoginCredentials(LoginObserver $input) 
  {
    $this->username = $input->getRequestUsername();
    $this->password = $input->getRequestPassword();
  }

  /**
   * @return void
   */
  public function executeLogin(LoginObserver $view) 
  {
    if ($this->persistentUser->isErrors() == false) {
      $view->setCookieCredentials($this->username, $this->password);
      $view->refreshPage();
    } else {
      $this->handleError($view);
    }
  }

  /**
   * @return void
   */
  public function getUserFromDatabase() 
  {
    return $this->dbHelper->findData(array(
      'username' => $this->username
    ));
  }

  /**
   * @param Type RegisterObserver OR LoginObserver - Both handle error output same way
   * @return void
   */
  public function handleError($view)
  {
    $view->setLastUsernameInput($this->username);
    $view->setRequestMessage($this->persistentUser->getMessage());
  }
}