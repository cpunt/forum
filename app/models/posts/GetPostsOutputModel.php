<?php

namespace models\posts;

class GetPostsOutputModel extends \config\Database {
  private $iduser, $username;

  public function __construct($currentUserId, $currentUsername) {
    parent::__construct();
    $this->iduser = $currentUserId;
    $this->username = $currentUsername;
  }

  public function getOutput($result) {
    while($row = $result->fetch_assoc()) {
      if($row['type'] == 'comment') {
        $row = $this->getCommentOutput($row);
      } else {
        $row = $this->getPostOutput($row);
      }

      $rows[] = $row;
    }

    return $rows;
  }

  private function getPostOutput($row) {
    $row['saved'] = $this->isSaved($row['idpost'], 'post');
    $row['editable'] = $this->username == $row['username'] ? true : false;
    $row['text'] = htmlspecialchars($row['text']);
    $row['commentCount'] = $this->getCommentCount($row['idpost']);

    return $row;
  }

  private function getCommentOutput($row) {
    $row['saved'] = $this->isSaved($row['idcomment'], 'comment');
    $row['editable'] = $this->username == $row['username'] ? true : false;
    $row['text'] = htmlspecialchars($row['text']);

    if($row['idpost']) {
      $postData = $this->getPostDataForComment($row['idpost']);
      $row['title'] = $postData['title'];
      $row['postUsername'] = $postData['postUsername'];
    }

    return $row;
  }

  private function getCommentCount($idpost) {
    $query = "SELECT * FROM records WHERE idpost = ? AND type = 'comment'";
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('s', $idpost);
    $stmt->execute();
    $result = $stmt->get_result();
    $num_of_rows = $result->num_rows;
    $stmt->close();

    return $num_of_rows;
  }

  private function isSaved($id, $type) {
    $idrecord = $this->getIdrecord($id, $type);
    $query = "SELECT * FROM saved WHERE idrecord = ? AND iduser = ?";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('ii', $idrecord, $this->iduser);
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

  private function getIdrecord($id, $type) {
    if($type == 'comment') {
      $query = "SELECT idrecord FROM records
      WHERE idcomment = ?";
    } else {
      $query = "SELECT idrecord FROM records
      WHERE idpost = ?
      AND idcomment IS NULL";
    }

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->bind_result($idrecord);
    $stmt->fetch();
    $stmt->close();

    return $idrecord;
  }

  private function getPostDataForComment($idpost) {
    $query = "SELECT records.title, userbase.username
    FROM records
    LEFT JOIN userbase ON records.iduser = userbase.iduser
    WHERE idpost = ?
    AND idcomment IS NULL";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('s', $idpost);
    $stmt->execute();
    $stmt->bind_result($title, $username);
    $fetch = $stmt->fetch();
    $stmt->close();
    if($fetch) {
      $data['title'] = $title;
      $data['postUsername'] = $username;

      return $data;
    } else {
      return [];
    }
  }
}
