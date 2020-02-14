<?php

class PostUI {
  protected $conn;

  public function __construct($conn) {
    $this->conn = $conn;
  }

  protected function commentCount($id) {
    $query = "SELECT * FROM comments WHERE idpostcom = ?";
    $sql = ($this->conn)->prepare($query);
    $sql->bind_param('i', $id);
    $sql->execute();
    $result = $sql->get_result();
    $num_of_rows = $result->num_rows;
    $sql->close();
    return $num_of_rows;
  }

  protected function saveCheckPosts($postId) {
    $idUser = (int) $this->loggedInUserId();
    $query = "SELECT * FROM saved WHERE idpost = ? AND iduser = ?";
    $sql = ($this->conn)->prepare($query);
    $sql->bind_param('ii', $postId, $idUser);
    $sql->execute();
    $result = $sql->get_result();
    $num_of_rows = $result->num_rows;
    $sql->close();
    if($num_of_rows > 0) {
      return true;
    } else {
      return false;
    }
  }

  protected function returnLoggedInUser() {
    $token = $_COOKIE['jwt'];
    $sql = ($this->conn)->prepare("SELECT username FROM userbase WHERE jwt = ?");
    $sql->bind_param("s", $token);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_array(MYSQLI_NUM)[0];
    $sql->close();
    return $row;
  }

  protected function loggedInUserId() {
    $username = $this->returnLoggedInUser();
    $userQuery = ($this->conn)->prepare("SELECT iduser FROM userbase WHERE username = ?");
    $userQuery->bind_param("s", $username);
    $userQuery->execute();
    $userQuery->bind_result($idUser);
    if($userQuery->fetch()) {
      return $idUser;
    }
    $userQuery->close();
  }

  protected function postOutput($result) {
    while($row = $result->fetch_assoc()) {
      if(tokenValidation($this->conn)) {
        $row['editable'] = $this->returnLoggedInUser() === $row['username'] ? true : false;
      }
      $row['comments'] = $this->commentCount($row['id']);
      $row['saved'] = $this->saveCheckPosts($row['id']);

      if($row['type'] === 'image' || $row['type'] === 'video') {
        $row['path'] = 'uploads/' . $row['file_name'];
      } else if($row['type'] === 'text'){
        $row['content'] = htmlspecialchars($row['content']);
      } else {
        $row['url'] = htmlspecialchars($row['url']);
      }

      $rows[] = $row;
    }
    return $rows;
  }
}

class CirclePosts extends PostUI {
  private $circle;

  public function __construct($conn, $circle) {
    parent::__construct($conn);
    $this->circle = $circle;
  }

  public function posts() {
    $circleQuery = ($this->conn)->prepare("SELECT 1 FROM circles WHERE circleName = ?");
    $circleQuery->bind_param("s", $this->circle);
    $circleQuery->execute();
    $circleQuery->bind_result($found);
    $circleQuery->fetch();
    $circleQuery->close();
    $msg = array();

    if($found) {
      $query = "SELECT post.id, post.type, post.title, post.content, post.file_name, post.url, post.posted, circles.circleName, userbase.username
      FROM post
      LEFT JOIN userbase ON post.iduser = userbase.iduser
      LEFT JOIN circles ON post.idcircle = circles.idcircle
      WHERE circleName = ?
      ORDER BY id DESC";
      $sql = ($this->conn)->prepare($query);
      $sql->bind_param("s", $this->circle);
      $sql->execute();
      $result = $sql->get_result();
      $num_of_rows = $result->num_rows;
      if($num_of_rows > 0) {
        $rows = $this->postOutput($result);
      } else {
        $rows['noPosts'] = 'This circle has no posts yet';
      }
    } else {
      $rows['noCircle'] = 'Circle does not exist';
    }
    echo json_encode($rows);
  }
}
