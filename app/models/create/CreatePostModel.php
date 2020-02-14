<?php
namespace models\create;

class CreatePostModel extends \config\Database {
  private $tainted = [],
          $clean = [],
          $errors = [];

  public function __construct(array $postData) {
    parent::__construct();
    date_default_timezone_set('Europe/London');

    $this->tainted['idCircle'] = $postData['idCircle'];
    $this->tainted['title'] = $postData['title'];
    $this->tainted['text'] = $postData['text'];
    $this->tainted['type'] = $postData['type'];

    $this->clean['idUser'] = $postData['idUser'];
    $this->clean['username'] = $postData['username'];
    $this->clean['date'] = date('d\/m\/y');
  }

  public function createPost() {
    $date = new \DateTime();
    $idpost = $date->getTimestamp() . uniqid();

    $query = "INSERT INTO records (idpost, type, title, text, iduser, idcircle, created)
    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('ssssiis', $idpost, $this->clean['type'], $this->clean['title'], $this->clean['text'], $this->clean['idUser'], $this->clean['idCircle'], $this->clean['date']);
    $execution = $stmt->execute();
    $stmt->close();

    if($execution) {
      if($this->clean['type'] == 'image' || $this->clean['type'] == 'video') {
        if(!$this->move($this->clean['file'])) {
          return false;
        }
      }
      return $this->created();
    }
  }



  public function validatePost() {
    $titleLen = strlen($this->tainted['title']);
    $textLen = strlen($this->tainted['text']);
    $types = ['text', 'link', 'image', 'video'];

    if(!in_array($this->tainted['type'], $types)) {
      $this->errors['type'] = true;
    } else {
      $this->clean['type'] = $this->tainted['type'];
    }

    if($titleLen == 0 || $titleLen > 100) {
      $this->errors['title'] = true;
    } else {
      $this->clean['title'] = $this->tainted['title'];
    }

    if(!$this->tainted['idCircle']) {
      $this->errors['circle'] = true;
    } else {
      $this->clean['idCircle'] = $this->tainted['idCircle'];
    }

    switch($this->clean['type']) {
      case 'image':
      case 'video':
        $extensions = ['jpg', 'jpeg', 'png', 'gif', 'mov', 'm4v', 'mp4'];
        $file_ext = strtolower(end(explode('.', $this->tainted['file']['name'])));
        $file_size = $this->tainted['file']['size'] / 1000000;

        if(count($this->tainted['file']['tmp_name']) > 1 || !in_array($file_ext, $extensions) || $file_size > 200) {
          $this->errors['file'] = true;
        } else {
          $this->clean['file'] = $this->tainted['file'];
        }
        break;
      case 'link':
        if(!filter_var($this->tainted['text'], FILTER_VALIDATE_URL) || $textLen == 0 || $textLen > 1000) {
          $this->errors['text'] = true;
        } else {
          $this->clean['text'] = $this->tainted['text'];
        }
        break;
      case 'text':
        if($textLen == 0 || $textLen > 5000) {
          $this->errors['text'] = true;
        } else {
          $this->clean['text'] = $this->tainted['text'];
        }
        break;
    }

    if(count($this->errors) > 0) {
      return false;
    } else {
      return true;
    }
  }

  public function getErrors() {
    return $this->errors;
  }

  public function setFileData($file, $fileName, $type) {
    $this->tainted['file'] = $file;
    $this->tainted['type'] = $type;
    $this->clean['text'] = $fileName;
  }


  private function created() {
    $data = [];
    $data['created'] = true;
    $data['username'] = $this->clean['username'];

    return $data;
  }

  private function move($file) {
    $fileId = $file['tmp_name'];
    $path = 'app/views/general/uploads/' . $file['name'];

    if(move_uploaded_file($fileId, $path)) {
      return true;
    } else {
      return false;
    }
  }
}
