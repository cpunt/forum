<?php
namespace controllers\requests;

class UserCredentials extends \core\Controller {

  public function __construct() {
    parent::__construct();

    if(!$this->userLoggedIn && isset($_POST['userCredentials'])) {
      $userCredentials = (array) json_decode($_POST['userCredentials']);
      $action = isset($userCredentials['action']) ? $userCredentials['action'] : null;
      $username = isset($userCredentials['username']) ? $userCredentials['username'] : null;
      $password = isset($userCredentials['pw']) ? $userCredentials['pw'] : null;
      $conPassword = isset($userCredentials['cPw']) ? $userCredentials['cPw'] : null;

      switch($action) {
        case 'signup':
          $signupModel = new \models\userCredentials\SignupModel($username, $password, $conPassword);
          $valid = $signupModel->signup();
          if(!$valid['login']) {
            echo json_encode($valid);
            break;
          }
        case 'login':
          $loginModel = new \models\userCredentials\LoginModel($username, $password);
          if($loginModel->validate()) {
            $loginModel->login();
            echo json_encode(['login' => true]);
          } else {
            echo json_encode(['login' => false]);
          }
          break;
      }
    }
  }
}
