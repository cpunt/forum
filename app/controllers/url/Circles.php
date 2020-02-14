<?php
namespace controllers\url;

class Circles extends \core\Controller {
  public function __construct() {
    parent::__construct();
    session_start();
    $_SESSION['offset'] = 0;

    $this->view('circles');
  }
}
