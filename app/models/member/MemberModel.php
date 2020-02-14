<?php

namespace models\member;

class MemberModel extends \config\Database {
  private $circle,
          $username;

  public function __construct($circle, $username) {
    parent::__construct();
    $this->circle = $circle;
    $this->username = $username;
  }

  public function circleInfo() {
    $info = [];

    $query = "SELECT circleName FROM Circles
    WHERE circleName = ?";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param("s", $this->circle);
    $stmt->execute();
    $stmt->store_result();
    $numberofrows = $stmt->num_rows;
    $stmt->close();

    if($numberofrows == 1) {
      if($this->username) {
        $info['memberInfo']['memberStatus'] = $this->memberStatus();
      }
      $info['memberInfo']['memberCount'] = $this->memberCount();
      $info['circleInfo'] = $this->circleDescription()[0];
    }

    return $info;
  }

  private function memberStatus() {
    $query = "SELECT users_circles.*
    FROM users_circles
    LEFT JOIN userbase ON users_circles.iduser = userbase.iduser
    LEFT JOIN circles ON users_circles.idcircle = circles.idcircle
    WHERE circles.circleName = ? AND userbase.username = ?";
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param("ss", $this->circle, $this->username);
    $stmt->execute();
    $stmt->store_result();
    $numberofrows = $stmt->num_rows;
    $stmt->close();
    return $numberofrows === 1 ? true : false;
  }

  public function memberCount() {
    $query = "SELECT circles.circleName FROM users_circles
    LEFT JOIN circles ON users_circles.idcircle = circles.idcircle
    WHERE circles.circleName = ?";
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param("s", $this->circle);
    $stmt->execute();
    $stmt->store_result();
    $numberofrows = $stmt->num_rows;
    $stmt->close();
    return $numberofrows;
  }

  private function circleDescription() {
    $query = "SELECT userbase.username, circles.circleDescription, circles.circleDate FROM circles
    LEFT JOIN userbase ON circles.iduser = userbase.iduser
    WHERE circleName = ?";
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param("s", $this->circle);
    $stmt->execute();
    $result = $stmt->get_result();
    $num_of_rows = $result->num_rows;
    if($num_of_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $row['circleDescription'] = htmlspecialchars($row['circleDescription'], ENT_QUOTES);
        $rows[] = $row;
      }
      return $rows;
    }
  }
}
