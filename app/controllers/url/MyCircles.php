<?php
namespace controllers\url;

class MyCircles extends \core\Controller {
  public function __construct($page=null, $circle=null) {
    parent::__construct();
    $pages = ['joined', 'created', 'edit'];


    if(in_array($page, $pages) && $this->userLoggedIn) {
      $helper = new \models\helper\HelperModel();
      $userId = $helper->getUserId($this->userLoggedIn);

      switch($page) {
        case 'edit':
          if($circle) {
            $circleEdit = new \models\circleList\CircleEditModel($userId, $circle);
            $circleInfo = $circleEdit->getCircleInfo();

            if($circleInfo) {
              $this->view("mycircles/$page", $circleInfo);
              return;
            }
          }
          break;
        case 'joined':
        case 'created':
          $circleListModel = new \models\circleList\CircleListModel();
          $myCircleList = $circleListModel->myCircles($userId, $page);

          $this->view("mycircles/$page", $myCircleList);
          return;
          break;
      }
    }

    $this->view('home');
  }
}
