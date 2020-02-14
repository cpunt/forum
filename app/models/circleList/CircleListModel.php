<?php
namespace models\circleList;

class CircleListModel extends \config\Database {
  public function __construct() {
    parent::__construct();
  }

  public function CircleList() {
    $query = "SELECT circleName FROM circles ORDER BY idcircle DESC";
    $stmt = ($this->conn)->prepare($query);
    $stmt->execute();
    $stmt->bind_result($circleList);
    $circlesArray = array();
    while($stmt->fetch()) {
      array_push($circlesArray, $circleList);
    }
    $stmt->close();
    return $circlesArray;
  }

  public function allCircles() {
    session_start();
    $offset = $_SESSION['offset'];
    $_SESSION['offset'] += 20;

    $query = "SELECT circles.circleName, circles.circleDate, userbase.username FROM circles
    LEFT JOIN userbase ON circles.iduser = userbase.iduser
    ORDER BY circles.idcircle DESC
    LIMIT 20
    OFFSET ?";
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('i', $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $num_of_rows = $result->num_rows;

    if($num_of_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $rows[] = $row;
      }

      return $rows;
    } else {
      return null;
    }
  }

  // public function allCircles() {
  //   $query = "SELECT circles.circleName, circles.circleDate, userbase.username FROM circles
  //   LEFT JOIN userbase ON circles.iduser = userbase.iduser
  //   ORDER BY circles.idcircle DESC";
  //   $stmt = ($this->conn)->prepare($query);
  //   $stmt->execute();
  //   $result = $stmt->get_result();
  //   $stmt->close();
  //   $num_of_rows = $result->num_rows;
  //
  //   if($num_of_rows > 0) {
  //     while($row = $result->fetch_assoc()) {
  //       $rows[] = $row;
  //     }
  //
  //     return $rows;
  //   } else {
  //     return null;
  //   }
  // }

  public function myCircles($userId, $page) {
    $query = $this->myCirclesQueries($page);
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $num_of_rows = $result->num_rows;

    if($num_of_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $rows[] = $row;
      }

      return $rows;
    } else {
      return null;
    }
  }

  public function myCirclesQueries($page) {
    switch($page) {
      case 'joined':
        $query = "SELECT circles.circleName, circles.circleDate, userbase.username FROM users_circles
        LEFT JOIN circles ON users_circles.idcircle = circles.idcircle
        LEFT JOIN userbase ON users_circles.iduser = userbase.iduser
        WHERE users_circles.iduser = ?
        ORDER BY users_circles.idusercircles DESC";
        break;
      case 'created':
        $query = "SELECT circles.circleName, circles.circleDate, userbase.username FROM circles
        LEFT JOIN userbase ON circles.iduser = userbase.iduser
        WHERE circles.iduser = ?
        ORDER BY circles.idcircle DESC";
        break;
    }

    return $query;
  }
}
