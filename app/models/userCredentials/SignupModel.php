<?php
namespace models\UserCredentials;

class SignupModel extends \config\Database {
  private $username,
          $password,
          $conPassword;

  public function __construct($username, $password, $conPassword) {
    parent::__construct();
    $this->username = $username;
    $this->password = $password;
    $this->conPassword = $conPassword;
  }

  public function signup() {
    $signupValidate = new SignupValidate($this->username, $this->password, $this->conPassword);
    $valid = $signupValidate->validate();
    if($valid['login']) {
      $hashPw = password_hash($this->password, PASSWORD_DEFAULT);
      $query = "INSERT INTO userbase (username, password) VALUES (?, ?)";
      $stmt = ($this->conn)->prepare($query);
      $stmt->bind_param("ss", $this->username, $hashPw);
      $stmt->execute();
      $stmt->close();
    }
    return $valid;
  }
}

class SignupValidate extends \config\Database {
  private $username,
          $password,
          $conPassword,
          $valid = [
          'validUsername' => true,
          'usernameFree' => true,
          'validPassword' => true,
          'matchingPasswords' => true,
          'login' => true
        ];

  public function __construct($username, $password, $conPassword) {
    parent::__construct();
    $this->username = $username;
    $this->password = $password;
    $this->conPassword = $conPassword;
  }

  public function validate() {
    if(!ctype_alnum($this->username) || strlen($this->username) < 3 || strlen($this->username) > 10)
      $this->valid['validUsername'] = false;

    if(!$this->usernameFree($this->username))
      $this->valid['usernameFree'] = false;

    if(!$this->validatePassword($this->password))
      $this->valid['validPassword'] = false;

    if($this->password != $this->conPassword)
      $this->valid['matchingPasswords'] = false;

    foreach($this->valid as $value) {
      if(!$value) {
        $this->valid['login'] = false;
        return $this->valid;
      }
    }

    return $this->valid;
  }

  private function validatePassword() {
    $uppercase = preg_match('@[A-Z]@', $this->password);
    $lowercase = preg_match('@[a-z]@', $this->password);
    $number = preg_match('@[0-9]@', $this->password);

    if(!$uppercase || !$lowercase || !$number || strlen($this->password) < 6) {
      return false;
    }

    return true;
  }

  private function usernameFree() {
    $query = "SELECT * FROM userbase WHERE username = ?";
    $sql = ($this->conn)->prepare($query);
    $sql->bind_param('s', $this->username);
    $sql->execute();
    $sql->store_result();
    $numRows = $sql->num_rows;
    $sql->close();
    if($numRows > 0) {
      return false;
    }

    return true;
  }
}
