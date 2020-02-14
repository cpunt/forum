<?php
namespace controllers\requests;

class Logout extends \core\Controller {

  public function __construct() {
    parent::__construct();
    if($this->userLoggedIn) {
      $jwt = new \models\tokens\JsonWebToken();
      $rt = new \models\tokens\RefreshToken();
      $jwt->unsetToken();
      $rt->unsetToken();
      echo true;
    }
  }
}
