<?php
namespace controllers\requests;

class PostOptions extends \core\Controller {
  public function __construct() {
    parent::__construct();

    if(!$this->userLoggedIn) {
      $data['loggedIn'] = false;
    } else {
      $data['loggedIn'] = true;

      switch($_SERVER['REQUEST_METHOD']) {
        case 'POST':
          $postOptions = (array) json_decode($_POST['postOptions']);
          break;
        case 'DELETE':
        case 'PATCH':
          $_VERB = [];
          parse_str(file_get_contents("php://input"), $_VERB);
          $postOptions = (array) json_decode($_VERB['postOptions']);
          break;
      }

      $idpost = $postOptions['idpost'];
      $helper = new \models\helper\helperModel;
      $iduser = $helper->getUserId($this->userLoggedIn);
      $postOptionsModel = new \models\actions\PostOptionsModel($idpost, $iduser);

      //Check if post saved cant save again
      switch($postOptions['action']) {
        case 'savePost':
          $data['saved'] = $postOptionsModel->savePost();
          break;
        case 'unsavePost':
          $data['saved'] = $postOptionsModel->unsavePost();
          break;
        case 'deletePost':
          $data['deleted'] = $postOptionsModel->deletePost();
          break;
        case 'updatePost':
          $content = $postOptions['content'];
          $data['updated'] = strlen($content) > 5000 ? false : $postOptionsModel->updatePost($content);
          break;
      }
    }

    echo json_encode($data);
  }
}
