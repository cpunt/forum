<?php
namespace controllers\requests;

class CreateCircle extends \core\Controller {

  public function __construct() {
    parent::__construct();

    if(isset($_POST['createCircle']) && $this->userLoggedIn) {
      $createCircle = (array) json_decode($_POST['createCircle']);
      $helper = new \models\helper\HelperModel;

      $circleId = $helper->getCircleId($createCircle['circle']);
      $userId = $helper->getUserId($this->userLoggedIn);

      $circle = $createCircle['circle'];
      $description = $createCircle['description'];

      $createCircleModel = new \models\create\CreateCircleModel($circle, $description);
      $createCircle = $createCircleModel->createCircle($circleId, $userId);

      echo json_encode($createCircle);
    }
  }
}
