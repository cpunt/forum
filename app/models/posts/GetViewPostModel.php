<?php
namespace models\posts;

class GetViewPostModel extends \config\Database {
  private $circle, $idpost;

  public function __construct($circle, $idpost) {
    parent::__construct();
    $this->circle = $circle;
    $this->idpost = $idpost;
  }

  public function getPost() {
    $query = "SELECT records.idpost,  records.type, records.title, records.text, userbase.username, circles.circleName, records.created
    FROM records
    LEFT JOIN userbase ON records.iduser = userbase.iduser
    LEFT JOIN circles ON records.idcircle = circles.idcircle
    WHERE circles.circleName = ?
    AND records.idpost = ?
    AND records.idcomment IS NULL";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param("ss", $this->circle, $this->idpost);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if($result->num_rows > 0) {
      return $result;
    } else {
      return [];
    }
  }

  public function validateEdit($iduser) {
    $query = "SELECT * FROM records
    LEFT JOIN circles ON records.idcircle = circles.idcircle
    WHERE records.idpost = ?
    AND records.type = 'text'
    AND circles.circleName = ?
    AND records.iduser = ?";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('ssi', $this->idpost, $this->circle, $iduser);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if($result->num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }
}
