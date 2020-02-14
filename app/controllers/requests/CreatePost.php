<?php
namespace controllers\requests;

class CreatePost extends \core\Controller {

  public function __construct() {
    parent::__construct();
    if($this->userLoggedIn && isset($_POST['createPost'])) {
      $createPost = (array) json_decode($_POST['createPost']);
      $helper = new \models\helper\HelperModel;
      $createPost['idCircle'] = $helper->getCircleId($createPost['circle']);
      $createPost['idUser'] = $helper->getUserId($this->userLoggedIn);
      $createPost['username'] = $this->userLoggedIn;
      $createPostModel = new \models\create\CreatePostModel($createPost);

      if($createPost['type'] == 'imageVideo' && isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $fileEditorModel = new \models\create\FileEditorModel($file);
        $renamedFile = $fileEditorModel->renameFile();
        $fileName = $renamedFile['name'];
        $type = explode("/", $file['type'])[0];

        if($type == 'image') {
          $fileEditorModel->imageResize();
        }

        $createPostModel->setFileData($renamedFile, $fileName, $type);
      }

      if(!$createPostModel->validatePost()) {
        echo json_encode($createPostModel->getErrors());
      } else {
        echo json_encode($createPostModel->createPost());
      }
    }
  }
}
