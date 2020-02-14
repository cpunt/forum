<?php
namespace models\helper;

class HelperModel extends \config\Database {
  public function __construct() {
    parent::__construct();
  }

  function getCircleId($circle) {
    $stmt = ($this->conn)->prepare("SELECT idcircle FROM circles WHERE circleName = ?");
    $stmt->bind_param("s", $circle);
    $stmt->execute();
    $stmt->bind_result($idCircle);
    $stmt->fetch();
    $stmt->close();
    return $idCircle ? $idCircle : null;
  }

  function getUserId($username) {
    $stmt = ($this->conn)->prepare("SELECT iduser FROM userbase WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($idUser);
    $stmt->fetch();
    $stmt->close();
    return $idUser ? $idUser : null;
  }
}
