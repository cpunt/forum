<?php
namespace models\create;

class fileEditorModel extends \config\Database {
  private $file;

  public function __construct($file) {
    $this->file = $file;
  }

  public function renameFile() {
    date_default_timezone_set('Europe/London');
    $file_ext = strtolower(end(explode('.', $this->file['name'])));
    $time = time();
    $id = uniqid();
    $name = "T$time" . "ID$id" . ".$file_ext";
    $this->file['name'] = $name;
    return $this->file;
  }

  public function imageResize() {
    $maxDim = 500;
    $file_name = $this->file['tmp_name'];
    list($width, $height, $type, $attr) = getimagesize($file_name);
    if($width > $maxDim || $height > $maxDim) {
      $target_filename = $file_name;
      $ratio = $width/$height;
      if($ratio > 1) {
          $new_width = $maxDim;
          $new_height = $maxDim/$ratio;
      } else {
          $new_width = $maxDim*$ratio;
          $new_height = $maxDim;
      }
      $src = imagecreatefromstring(file_get_contents($file_name));
      $dst = imagecreatetruecolor( $new_width, $new_height );
      imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
      imagedestroy($src);
      imagepng($dst, $target_filename); // adjust format as needed
      imagedestroy($dst);
    }
  }
}
