<?php
namespace controllers\url;

class ViewPost extends \core\Controller {
  public function __construct($circleName=null, $idpost=null) {
    parent::__construct();
    session_start();
    $_SESSION['offset'] = 0;

    $viewPostModel = new \models\posts\GetViewPostModel($circleName, $idpost);
    $result = $viewPostModel->getPost();

    if($result) {
      $helper = new \models\helper\HelperModel();
      $iduser = $helper->getUserId($this->userLoggedIn);

      $postOutputModel = new \models\posts\GetPostsOutputModel($iduser, $this->userLoggedIn);
      $postOutput = (array) $postOutputModel->getOutput($result)[0];

      $memberModel = new \models\member\memberModel($circleName, $this->userLoggedIn);
      $circleInfo = $memberModel->circleInfo();
      $postOutput['memberDiv'] = $circleInfo;

      $this->view('viewpost', $postOutput);
    } else {
      $this->view('home');
    }
  }
}
