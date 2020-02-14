<?php
namespace models\actions;

class PostOptionsModel extends \config\Database {
  private $idrecord,
          $iduser;

  public function __construct($idpost, $iduser) {
    parent::__construct();
    $this->idrecord = $this->getIdrecord($idpost);
    $this->iduser = $iduser;
  }

  public function savePost() {
    $query = "INSERT INTO saved (idrecord, iduser) VALUES(?, ?)";
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('si', $this->idrecord, $this->iduser);
    $execution = $stmt->execute();
    $stmt->close();
    if($execution) {
      return 'Unsave';
    }
  }

  public function unsavePost() {
    $query = "DELETE FROM saved WHERE idrecord = ? AND iduser = ?";
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('si', $this->idrecord, $this->iduser);
    $execution = $stmt->execute();
    $stmt->close();
    if($execution) {
      return 'Save';
    }
  }

  public function deletePost() {
    $fileName = $this->getPostFileName();

    if($fileName) {
      $path = "app/views/general/uploads/$fileName";
      if(file_exists($path)) {
        unlink($path);
      } else {
        return false;
      }
    }

    $query = "UPDATE records
    SET title = 'deleted', type = 'deleted', text = 'deleted'
    WHERE idrecord = ?
    AND iduser = ?";
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('si', $this->idrecord, $this->iduser);
    $execution = $stmt->execute();
    $stmt->close();
    return $execution;
  }

  public function updatePost($content) {
    $query = "UPDATE records
    SET text = ?
    WHERE idrecord = ?
    AND iduser = ?";
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('ssi', $content, $this->idrecord, $this->iduser);
    $execution = $stmt->execute();
    $stmt->close();
    return $execution;
  }

  private function getPostFileName() {
    $query = "SELECT text FROM records
    WHERE idrecord = ?
    AND iduser = ?
    AND type = 'image'
    OR type = 'video'";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('si', $this->idrecord, $this->iduser);
    $stmt->execute();
    $stmt->bind_result($fileName);
    $stmt->fetch();
    $stmt->close();

    return $fileName;
  }

  private function getIdrecord($idpost) {
    $query = "SELECT idrecord FROM records
    WHERE idpost = ?
    AND idcomment IS NULL";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('s', $idpost);
    $stmt->execute();
    $stmt->bind_result($idrecord);
    $stmt->fetch();
    $stmt->close();

    return $idrecord;
  }
}
