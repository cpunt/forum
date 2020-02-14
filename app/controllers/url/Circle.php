<?php
namespace controllers\url;

class Circle extends \core\Controller {
  public function __construct($circle=null) {
    parent::__construct();
    session_start();
    $_SESSION['offset'] = 0;
    $helper = new \models\helper\HelperModel();
    $circleId = $helper->getCircleId($circle);

    $data = [];
    $data['circleName'] = $circle;

    if($circleId) {
      $data['circleExists'] = true;
      $memberModel = new \models\member\MemberModel($circle, $this->userLoggedIn);
      $circleInfo = $memberModel->circleInfo();
      $data['memberDiv'] = $circleInfo;
    } else {
      $data['circleExists'] = false;
    }

    $this->view('circle', $data);
  }
}
