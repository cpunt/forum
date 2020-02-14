<?php
namespace models\actions;

class CommentOptionsModel extends \config\Database {
  private $userId, $idrecord;

  public function __construct($userId, $idcomment = null) {
    parent::__construct();
    $this->userId = $userId;
    $this->idrecord = $this->getIdrecord($idcomment);
  }

  public function saveComment() {
    $query = "INSERT INTO saved (idrecord, iduser) VALUES(?, ?)";
    $sql = ($this->conn)->prepare($query);
    $sql->bind_param('ii', $this->idrecord, $this->userId);
    $sql->execute();
    $sql->close();
    return 'Unsave';
  }

  public function unsaveComment() {
    $query = "DELETE FROM saved WHERE idrecord = ? AND iduser = ?";
    $sql = ($this->conn)->prepare($query);
    $sql->bind_param('ii', $this->idrecord, $this->userId);
    $sql->execute();
    $sql->close();
    return 'Save';
  }

  public function deleteComment() {
    $query = "DELETE FROM records WHERE idrecord = ? AND iduser = ?";
    $sql = ($this->conn)->prepare($query);
    $sql->bind_param('ii', $this->idrecord, $this->userId);
    $execution = $sql->execute();
    $sql->close();
    return $execution;
  }

  public function insertComment($idcircle, $idpost, $comment) {
    date_default_timezone_set('Europe/London');
    $date = date('d\/m\/y');
    $dateTime = new \DateTime();
    $idcomment = $dateTime->getTimestamp() . uniqid();
    $type = 'comment';

    $query = "INSERT INTO records(idpost, idcomment, type, text, iduser, idcircle, created)
    VALUES(?, ?, ?, ?, ?, ?, ?)";
    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('ssssiis', $idpost, $idcomment, $type, $comment, $this->userId, $idcircle, $date);
    $execution = $stmt->execute();
    $stmt->close();

    return $execution;
  }

  private function getIdrecord($idcomment) {
    $query = "SELECT idrecord FROM records
    WHERE idcomment = ?";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('s', $idcomment);
    $stmt->execute();
    $stmt->bind_result($idrecord);
    $stmt->fetch();
    $stmt->close();

    return $idrecord;
  }
}
