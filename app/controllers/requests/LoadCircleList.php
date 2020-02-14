<?php

namespace controllers\requests;

class LoadCircleList extends \core\Controller {

  public function __construct() {
    parent::__construct();
    $circleListModel = new \models\circleList\CircleListModel();
    $circleList = $circleListModel->allCircles();

    echo json_encode($circleList);
  }
}
