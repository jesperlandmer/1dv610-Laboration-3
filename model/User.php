<?php

namespace model;

require_once("PDOService.php");
require_once("PersistantUser.php");
require_once("Validator.php");

class User {

  private $username;
  private $password;
  private $passwordRepeat;

  public function __construct(RegisterObserver $observer) 
  {
    $this->username = $observer->getRequestUsername();
    $this->password = $observer->getRequestPassword();
    $this->passwordRepeat = $observer->getRequestPasswordRepeat();

    $this->dbHelper = new PDOService();
    $this->user = new PersistantUser($this->username, $this->password, $this->passwordRepeat);
    $this->validator = new Validator($this->user, $this->getUsernameFromDatabase());

    $this->newRegister($observer);
  }

  /**
   * @return void
   */
  public function newRegister(RegisterObserver $observer) 
  {
    if ($this->user->isErrors() == false) {
      $this->saveUserToDatabase();
    } else {
      $observer->setLastUsernameInput($this->username);
      $observer->setRequestMessage($this->user->getErrorMessage());
    }
  }

  /**
   * @return void
   */
  public function saveUserToDatabase() 
  {
    assert(isset($this->username));
    assert(isset($this->password));

    $this->userData = $this->dbHelper->saveData(array(
      'username' => $this->username,
      'password' => $this->getHashedPassword()
    ));
  }

  /**
   * @return void
   */
  public function getUsernameFromDatabase() 
  {
    assert(isset($this->username));

    return $this->dbHelper->findData(array(
      'username' => $this->username
    ));
  }

  /**
   * @return string
   */
  private function getHashedPassword() {
    return password_hash("$this->password", PASSWORD_BCRYPT, ["cost" => 8]);
  }
}