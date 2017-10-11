<?php

namespace model;

require_once("dbHelpers/PDOService.php");
require_once("PersistantUser.php");
require_once("Validator.php");

class RegisterModel {

  private $username;
  private $password;
  private $passwordRepeat;

  public function __construct() 
  {
    $this->dbHelper = new PDOService();
    $this->persistentUser = new PersistantUser();
  }

  /**
   * @return void
   */
  public function newRegister(RegisterObserver $observer) 
  {
    $this->setRegisterCredentials($observer);
    $this->persistentUser->newRegister($this);
    $this->executeRegister($observer);
  }

  /**
   * @return void
   */
  public function setRegisterCredentials(RegisterObserver $input) 
  {
    $this->username = $input->getRequestUsername();
    $this->password = $input->getRequestPassword();
    $this->passwordRepeat = $input->getRequestPasswordRepeat();
  }

  /**
   * @return void
   */
  public function executeRegister(RegisterObserver $view) 
  {
    if ($this->persistentUser->isErrors() == false) {
      $this->saveUserToDatabase();
      $view->redirectToHomePage();
    } else {
      $this->handleError($view);
    }
  }
  /**
   * @return void
   */
  public function saveUserToDatabase() 
  {
    $this->userData = $this->dbHelper->saveData(array(
      'username' => $this->username,
      'password' => $this->getHashedPassword()
    ));
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
   * @return string
   */
  public function getUsername() 
  {
    return $this->username;
  }
  /**
   * @return string
   */
  public function getPassword() 
  {
    return $this->password;
  }
  /**
   * @return string
   */
  public function getPasswordRepeat() 
  {
    assert(isset($this->passwordRepeat));
    return $this->passwordRepeat;
  }
  /**
   * @return string
   */
  private function getHashedPassword() 
  {
    return password_hash("$this->password", PASSWORD_BCRYPT, ["cost" => 8]);
  }

  /**
   * @param Type RegisterObserver OR LoginObserver - Both handle error output same way
   * @return void
   */
  public function handleError($view)
  {
    $view->setLastUsernameInput($this->persistentUser->getUsername());
    $view->setRequestMessage($this->persistentUser->getMessage());
  }
}