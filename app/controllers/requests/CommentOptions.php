<?php
namespace controllers\requests;

class CommentOptions extends \core\Controller {
  public function __construct() {
    parent::__construct();

    if(!$this->userLoggedIn) {
      $data['loggedIn'] = false;
    } else {
      $data['loggedIn'] = true;

      switch($_SERVER['REQUEST_METHOD']) {
        case 'POST':
          $commentOptions = (array) json_decode($_POST['commentOptions']);
          break;
        case 'DELETE':
        case 'PATCH':
          $_VERB = [];
          parse_str(file_get_contents("php://input"), $_VERB);
          $commentOptions = (array) json_decode($_VERB['commentOptions']);
          break;
      }

      $helper = new \models\helper\helperModel;
      $userId = $helper->getUserId($this->userLoggedIn);
      $idcomment = $commentOptions['idcomment'];
      $commentOptionsModel = new \models\actions\CommentOptionsModel($userId, $idcomment);

      switch($commentOptions['action']) {
        case 'saveComment':
          $data['text'] = $commentOptionsModel->saveComment();
          break;
        case 'unsaveComment':
          $data['text'] = $commentOptionsModel->unsaveComment();
          break;
        case 'deleteComment':
          $data['deleted'] = $commentOptionsModel->deleteComment();
          break;
        case 'newComment':
          $idcircle = $helper->getCircleId($commentOptions['circle']);
          $idpost = $commentOptions['id'];
          $comment = $commentOptions['comment'];

          $data['newComment'] = $commentOptionsModel->insertComment($idcircle, $idpost, $comment);
          break;
      }
    }

    echo json_encode($data);
  }
}
