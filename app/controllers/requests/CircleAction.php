<?php
namespace controllers\requests;

class CircleAction extends \core\Controller {

  public function __construct() {
    parent::__construct();

    if(!$this->userLoggedIn) {
      $data['loggedIn'] = false;
    } else {
      $data['loggedIn'] = true;

      switch($_SERVER['REQUEST_METHOD']) {
        case 'POST':
          $circleAction = (array) json_decode($_POST['circleAction']);
          break;
        case 'DELETE':
          $_DELETE = [];
          parse_str(file_get_contents("php://input"), $_DELETE);
          $circleAction = (array) json_decode($_DELETE['circleAction']);
          break;
      }

      $action = $circleAction['action'];
      $circle = $circleAction['circle'];

      $helper = new \models\helper\HelperModel();
      $circleId = $helper->getCircleId($circle);
      $userId = $helper->getUserId($this->userLoggedIn);

      $memberActions = new \models\member\MemberActionsModel($circleId, $userId);
      switch($action) {
        case 'joinCircle':
          $memberActions->joinCircle();
          break;
        case 'leaveCircle':
          $memberActions->leaveCircle();
          break;
      }

      $memberModel = new \models\member\MemberModel($circle, $this->userLoggedIn);
      $data['members'] = $memberModel->memberCount();
      $data['status'] = $action == 'joinCircle' ? 'Leave circle' : 'Join circle';
    }

    echo json_encode($data);
  }
}
