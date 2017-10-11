<?php

namespace model;

require_once("dbHelpers/PDOService.php");
require_once("PersistantUser.php");

class LoginModel {

  private $username;
  private $password;

  public function __construct() 
  {
    $this->dbHelper = new PDOService();
    $this->persistentUser = new PersistantUser();
  }

  /**
   * @return void
   */
  public function newLogin(LoginObserver $observer) 
  {
    $this->setLoginCredentials($observer);
    $this->executeLogin($observer);
  }
   /**
   * @return boolean
   */
  public function isLoggedIn(string $username, string $password)
  {
    $this->username = $username;
    $this->password = $password;

    return $this->isExistingUser();
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
    if ($this->isUsernameInput() == false) {
        $view->setRequestMessage(\view\MessageView::ErrorNoUserNameInput);

    } else if ($this->isPasswordInput() == false) {
        $view->setRequestMessage(\view\MessageView::ErrorNoPasswordInput);
        
    } else if ($this->isExistingUser() == false) {
        $view->setLastUsernameInput($this->username);
        $view->setRequestMessage(\view\MessageView::ErrorNoUserFound);

    } else {
        $view->setCookieCredentials($this->username, $this->password);
        $view->refreshPage();
    }
  }

   /**
   * @return boolean
   */
  public function isUsernameInput()
  {
      return strlen($this->username) > 0;
  }
   /**
   * @return boolean
   */
  public function isPasswordInput()
  {
      return strlen($this->password) > 0;
  }
   /**
   * @return boolean
   */
  public function isExistingUser()
  {
      return password_verify($this->password, $this->getUserFromDatabase()->fetch()["password"]);
  }

  /**
   * @return PDOStatement
   */
  public function getUserFromDatabase() 
  {
    return $this->dbHelper->findData(array(
      "username" => $this->username
    ));
  }

   /**
   * @return string
   */
  public function getNewRegisterUsername()
  {
    if ($this->persistentUser->getUsername() != null) {
        return $this->persistentUser->getUsername();
    }
  }
   /**
   * @return string
   */
  public function getNewRegisterMessage()
  {
    if ($this->persistentUser->getMessage() != null) {
        return $this->persistentUser->getMessage();
    }
  }
}