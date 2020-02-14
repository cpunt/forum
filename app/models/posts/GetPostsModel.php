<?php

namespace models\posts;

class GetPostsModel extends \config\Database {
  private $offset;

  public function __construct() {
    parent::__construct();
    session_start();
    $this->offset = $_SESSION['offset'];
    $_SESSION['offset'] += 8;
  }

  public function getHomePosts() {
    $query = "SELECT records.idpost,  records.type, records.title, records.text, userbase.username, circles.circleName, records.created
    FROM records
    LEFT JOIN userbase ON records.iduser = userbase.iduser
    LEFT JOIN circles ON records.idcircle = circles.idcircle
    WHERE records.idcomment IS NULL
    AND records.type <> 'deleted'
    ORDER BY records.idrecord DESC
    LIMIT 8
    OFFSET ?";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('i', $this->offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $num_of_rows = $result->num_rows;

    if($num_of_rows > 0) {
      return $result;
    } else {
      return [];
    }
  }

  public function getMyFeedPosts($iduser) {
    $query = "SELECT records.idpost, records.type, records.title, records.text, userbase.username, circles.circleName, records.created
    FROM users_circles
    LEFT JOIN records ON users_circles.idcircle = records.idcircle
    LEFT JOIN circles ON records.idcircle = circles.idcircle
    LEFT JOIN userbase ON records.iduser = userbase.iduser
    WHERE users_circles.iduser = ?
    AND records.idpost <> true
    AND records.type <> 'deleted'
    AND records.idcomment IS NULL
    ORDER BY records.idrecord DESC
    LIMIT 8
    OFFSET ?";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param("ii", $iduser, $this->offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $num_of_rows = $result->num_rows;

    if($num_of_rows > 0) {
      return $result;
    } else {
      return [];
    }
  }

  public function getCirclePosts($circle) {
    $query = "SELECT records.idpost,  records.type, records.title, records.text, userbase.username, circles.circleName, records.created
    FROM records
    LEFT JOIN userbase ON records.iduser = userbase.iduser
    LEFT JOIN circles ON records.idcircle = circles.idcircle
    WHERE circleName = ?
    AND records.type <> 'deleted'
    AND records.idcomment IS NULL
    ORDER BY records.idrecord DESC
    LIMIT 8
    OFFSET ?";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param("si", $circle, $this->offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $num_of_rows = $result->num_rows;

    if($num_of_rows > 0) {
      return $result;
    } else {
      return [];
    }
  }

  public function getViewComments($circleName, $idpost) {
    $query = "SELECT records.idcomment, records.type, records.text, records.created, userbase.username, circles.circleName
    FROM records
    LEFT JOIN userbase ON records.iduser = userbase.iduser
    LEFT JOIN circles ON records.idcircle = circles.idcircle
    WHERE idpost = ?
    AND circleName = ?
    AND type = 'comment'
    ORDER BY records.idrecord DESC
    LIMIT 8
    OFFSET ?";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param("ssi", $idpost, $circleName, $this->offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $num_of_rows = $result->num_rows;

    if($num_of_rows > 0) {
      return $result;
    } else {
      return [];
    }
  }

  public function getProfile($iduser, $type) {
    $query = $this->getQuery($type);

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param("ii", $iduser, $this->offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $num_of_rows = $result->num_rows;

    if($num_of_rows > 0) {
      return $result;
    } else {
      return [];
    }
  }

  public function getQuery($type) {
    switch($type) {
      case 'posts':
        $query = "SELECT records.idpost,  records.type, records.title, records.text, userbase.username, circles.circleName, records.created
        FROM records
        LEFT JOIN userbase ON records.iduser = userbase.iduser
        LEFT JOIN circles ON records.idcircle = circles.idcircle
        WHERE records.iduser = ?
        AND records.idcomment IS NULL
        AND records.type <> 'deleted'
        ORDER BY records.idrecord DESC
        LIMIT 8
        OFFSET ?";
        break;
      case 'comments':
        $query = "SELECT records.idpost, records.idcomment, records.type, records.text, userbase.username, circles.circleName, records.created
        FROM records
        LEFT JOIN userbase ON records.iduser = userbase.iduser
        LEFT JOIN circles ON records.idcircle = circles.idcircle
        WHERE records.iduser = ?
        AND records.idcomment IS NOT NULL
        ORDER BY records.idrecord DESC
        LIMIT 8
        OFFSET ?";
        break;
      case 'saved':
        $query = "SELECT records.idpost, records.idcomment,  records.type, records.title, records.text, records.created, userbase.username, circles.circleName FROM records
        LEFT JOIN userbase ON records.iduser = userbase.iduser
        LEFT JOIN circles ON records.idcircle = circles.idcircle
        LEFT JOIN saved ON records.idrecord = saved.idrecord
        WHERE saved.iduser = ?
        ORDER BY saved.idsaved DESC
        LIMIT 8
        OFFSET ?";
        break;
    }

    return $query;
  }
}
