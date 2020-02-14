<?php
namespace controllers\url;

class EditPost extends \core\Controller {
  public function __construct($circleName=null, $idpost=null) {
    parent::__construct();
    session_start();
    $_SESSION['offset'] = 0;

    $helper = new \models\helper\HelperModel();
    $userId = $helper->getUserId($this->userLoggedIn);
    $viewPostModel = new \models\posts\GetViewPostModel($circleName, $idpost);

    if($viewPostModel->validateEdit($userId)) {
      $result = $viewPostModel->getPost();
      $postOutputModel = new \models\posts\GetPostsOutputModel($userId, $this->userLoggedIn);
      $postOutput = (array) $postOutputModel->getOutput($result)[0];

      $memberModel = new \models\member\memberModel($circleName, $this->userLoggedIn);
      $circleInfo = $memberModel->circleInfo();
      $postOutput['memberDiv'] = $circleInfo;

      $this->view('editpost', $postOutput);
    } else {
      $this->view('home');
    }
  }
}
