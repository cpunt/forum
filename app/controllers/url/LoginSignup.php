<?php
namespace controllers\url;

class LoginSignup extends \core\Controller {
  public function __construct() {
    parent::__construct();
    $this->view('loginsignup');
  }
}
