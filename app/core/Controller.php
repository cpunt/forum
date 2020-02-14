<?php
namespace core;

class Controller {
  protected $userLoggedIn;

  protected function __construct() {
    $authenticateUser = new \models\tokens\AuthenticateUser();
    $this->userLoggedIn = $authenticateUser->authenticate();
  }

  protected function view($view, $data = null) {
    $path = 'app/views/' . $view . '/index.php';

    if(file_exists($path))
      require_once $path;
  }
}
