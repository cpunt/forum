<?php
namespace models\circleList;

class CircleEditModel extends \config\Database {
  private $userId, $circle;

  public function __construct($userId, $circle) {
    parent::__construct();
    $this->userId = $userId;
    $this->circle = $circle;
  }

  public function getCircleInfo() {
    $query = "SELECT circleName, circleDescription FROM circles
    WHERE iduser = ?
    AND circleName = ?";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('is', $this->userId, $this->circle);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $num_of_rows = $result->num_rows;

    if($num_of_rows == 1) {
      $row = $result->fetch_assoc();
      return $row;
    }
  }

  public function updateCircleDescription($description) {
    $query = "UPDATE circles
    SET circleDescription = ?
    WHERE circleName = ?
    AND iduser = ?";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('ssi', $description, $this->circle, $this->userId);
    $execute = $stmt->execute();
    $stmt->close();

    if($execute) {
      return true;
    } else {
      return false;
    }
  }
}
