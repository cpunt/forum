<?php

namespace controllers\requests;

class UpdateCircle extends \core\Controller {
  public function __construct() {
    parent::__construct();
    if($this->userLoggedIn) {
      $helper = new \models\helper\HelperModel();
      $userId = $helper->getUserId($this->userLoggedIn);

      $_PATCH = [];
      parse_str(file_get_contents("php://input"), $_PATCH);
      $updateCircle = (array) json_decode($_PATCH['updateCircle']);
      $circle = $updateCircle['circle'];
      $description = $updateCircle['description'];

      $circleEdit = new \models\circleList\CircleEditModel($userId, $circle);
      $circleInfo = $circleEdit->updateCircleDescription($description);

      if($circleInfo) {
        $data['update'] = true;
        $data['circle'] = $circle;
      } else {
        $data['update'] = false;
      }
      echo json_encode($data);
    }
  }
}
