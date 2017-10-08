<?php

namespace model;

require_once("UserObserver.php");
require_once("DatabaseHelper.php");
require_once("PersistantUser.php");
require_once("Validator.php");

class User implements UserObserver {

  public function __construct(string $username, string $password, string $passwordRepeat) 
  {
    $this->dbHelper = new DatabaseHelper();
    $this->user = new PersistantUser($username, $password, $passwordRepeat);
    $this->validator = new Validator($this->user);
  }

  /**
   * @return void
   */
  public function saveUserToDatabase(string $username, string $password) 
  {
    assert(isset($username));
    assert(isset($password));

    if ($this->user->isErrors() == false) {
      $this->userData = $this->dbHelper->saveData(array(
        'username' => $username,
        'password' => $this->hashString($password)
      ));
    }
  }

  /**
   * @return void
   */
  public function getUserFromDatabase(string $username) 
  {
    assert(isset($username));

    return $this->dbHelper->findData(array(
      'username' => $username
    ));
  }

  /**
   * @return string
   */
  private function hashString(string $password) {
    return password_hash("$password", PASSWORD_BCRYPT, ["cost" => 8]);
  }
}