<?php
namespace models\member;

class MemberActionsModel extends \config\Database {
  private $circleId,
          $userId;

  public function __construct(int $circleId, int $userId) {
    parent::__construct();
    $this->circleId = $circleId;
    $this->userId = $userId;
  }

  public function joinCircle() {
    //Add error check?
    $query = "INSERT INTO users_circles (idCircle, idUser) VALUES (?, ?)";
    $sql = ($this->conn)->prepare($query);
    $sql->bind_param("ss", $this->circleId, $this->userId);
    $sql->execute();
    $sql->close();
    return true;
  }

  public function leaveCircle() {
    //Add error check?
    $query = "DELETE FROM users_circles WHERE idcircle = ? AND iduser = ?";
    $sql = ($this->conn)->prepare($query);
    $sql->bind_param("ss", $this->circleId, $this->userId);
    $sql->execute();
    $sql->close();
    return true;
  }
}
