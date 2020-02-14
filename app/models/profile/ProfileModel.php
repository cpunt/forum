<?php
namespace models\profile;

class ProfileModel extends \config\Database {
  private $username,
          $userId,
          $page;

  public function __construct($username, $userId, $page) {
    parent::__construct();
    $this->username = $username;
    $this->userId = $userId;
    $this->page = $page;
  }

  public function getPosts() {
    $query = $this->getQuery();

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param("i", $this->userId);
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

  public function getComments($userLoggedIn) {
    $query = $this->getCommentQuery();

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('i', $this->userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $num_of_rows = $result->num_rows;
    if($num_of_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $row['saved'] = $this->isCommentSaved($row['idcomments']);
        $row['editable'] = $this->username == $userLoggedIn ? true : false;
        $row['commentsUsername'] = $this->username;
        $row['comment'] = htmlspecialchars($row['comment']);
        $rows[] = $row;
      }
      return $rows;
    } else {
      return [];
    }
  }

  private function isCommentSaved($commentId) {
    $query = "SELECT * FROM saved WHERE idcomment = ? AND iduser = ?";
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('ii', $commentId, $this->userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $num_of_rows = $result->num_rows;
    $stmt->close();
    if($num_of_rows > 0) {
      return true;
    } else {
      return false;
    }
  }

  private function getPostQuery() {
    switch($this->page) {
      case 'posts':
        $query = "SELECT post.id, post.type, post.title, post.content, post.file_name, post.link, post.posted, userbase.username, circles.circleName
        FROM post
        LEFT JOIN userbase ON post.iduser = userbase.iduser
        LEFT JOIN circles ON post.idcircle = circles.idcircle
        WHERE post.iduser = ?
        ORDER BY id DESC";
        break;
      case 'saved':
        $query = "SELECT post.id, post.type, post.title, post.content, post.file_name, post.link, post.posted, userbase.username, circles.circleName, saved.idsaved
        FROM post
        LEFT JOIN saved ON post.id = saved.idpost
        LEFT JOIN userbase ON post.iduser = userbase.iduser
        LEFT JOIN circles ON post.idcircle = circles.idcircle
        WHERE saved.iduser = ?
        ORDER BY saved.idsaved DESC";
        break;
    }
    return $query;
  }

  private function getCommentQuery() {
    switch($this->page) {
      case 'comments':
        $query = "SELECT comments.*, userbase.username, post.title, post.iduser, post.posted, circles.circleName FROM comments
        LEFT JOIN post ON comments.idpostcom = post.id
        LEFT JOIN userbase ON post.iduser = userbase.iduser
        LEFT JOIN circles ON comments.idcirclecom = circles.idcircle
        WHERE comments.idusercom = ?
        ORDER BY comments.idcomments desc";
        break;
      case 'saved':
        $query  = "SELECT  comments.*, userbase.username, post.title, post.iduser, post.posted, circles.circleName, saved.idsaved
        FROM comments
        LEFT JOIN saved ON comments.idcomments = saved.idcomment
        LEFT JOIN post ON comments.idpostcom = post.id
        LEFT JOIN userbase ON post.iduser = userbase.iduser
        LEFT JOIN circles ON comments.idcirclecom = circles.idcircle
        WHERE saved.iduser = ?
        ORDER BY saved.idsaved DESC";
        break;
    }
    return $query;
  }
}
