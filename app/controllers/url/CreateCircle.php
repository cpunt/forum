<?php
namespace controllers\url;

class CreateCircle extends \core\Controller {
  public function __construct() {
    parent::__construct();
    if($this->userLoggedIn) {
      $this->view("createcircle");
    } else {
      $this->view("loginsignup");
    }
  }
}
