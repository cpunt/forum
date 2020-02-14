<?php
namespace models\UserCredentials;

class LoginModel extends \config\Database {
  private $username,
          $password;

  public function __construct($username, $password) {
    parent::__construct();
    $this->username = $username;
    $this->password = $password;
  }

  public function validate() {
    $query = "SELECT password FROM userbase
    WHERE username = ?";
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param("s", $this->username);
    $stmt->execute();
    $stmt->bind_result($hash);
    $stmt->fetch();
    $stmt->close();

    if($hash) {
      if(password_verify($this->password, $hash)) {
        return true;
      }
    }

    return false;
  }

  public function login() {
    $jwt = new \models\tokens\JsonWebToken();
    $rt = new \models\tokens\RefreshToken();
    $jwt->setToken($this->username);
    $rt->setToken($this->username);

  }
}
