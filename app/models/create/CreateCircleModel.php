<?php
namespace models\create;

class CreateCircleModel extends \config\Database {
  private $tainted = [],
          $clean = [],
          $errors = [];

  public function __construct($circle, $description) {
    parent::__construct();
    $this->tainted['circle'] = trim($circle);
    $this->tainted['description'] = trim($description);
  }

  public function createCircle($circleId, $userId) {
    if($this->validate($circleId)) {
      date_default_timezone_set('Europe/London');
      $date = date('d\/m\/y');
      $query = "INSERT INTO circles (circleName, circleDescription, circleDate, iduser)
      VALUES(?, ?, ?, ?)";
      $stmt = ($this->conn)->prepare($query);
      $stmt->bind_param('sssi', $this->clean['circle'], $this->clean['description'], $date, $userId);
      $execution = $stmt->execute();
      $stmt->close();
      if(!$execution) {
        $this->errors['error'] = true;
      } else {
        $this->errors['circle'] = $this->clean['circle'];
        $this->errors['error'] = false;
      }
    }

    return $this->errors;
  }

  private function validate($circleId) {
    $circleLen = strlen($this->tainted['circle']);
    $descriptionLen = strlen($this->tainted['description']);

    if($circleLen < 3 || $circleLen > 50) {
      $this->errors['circleLen'] = true;
    }

    if(!ctype_alnum($this->tainted['circle'])) {
      $this->errors['alphaNum'] = true;
    }

    if($circleId) {
      $this->errors['circleTaken'] = true;
    }

    if($descriptionLen > 200) {
      $this->errors['descriptionLen'] = true;
    }

    if(count($this->errors) > 0) {
      $this->errors['error'] = true;
      return false;
    } else {
      $this->clean['circle'] = $this->tainted['circle'];
      $this->clean['description'] = $this->tainted['description'];
      return true;
    }
  }
}
