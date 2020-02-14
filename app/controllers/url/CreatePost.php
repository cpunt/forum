<?php
namespace controllers\url;

class CreatePost extends \core\Controller {
  public function __construct($page='text', $circle=null) {
    parent::__construct();
    $valid = [
      'text',
      'imagevideo',
      'link'
    ];

    if($this->userLoggedIn && in_array($page, $valid)) {
      $data = [];
      $circleListModel = new \models\circleList\CircleListModel();
      $data['circleList'] = $circleListModel->circleList();
      if($circle) {
        $data['circle'] = $circle;
      }

      $this->view("createpost/$page", $data);
    } else {
      $this->view("loginsignup");
    }
  }
}
