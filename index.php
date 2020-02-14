<?php
require_once 'app/autoloader.php';
require_once 'vendor/autoload.php';

if(isset($_SERVER['REQUEST_METHOD'])) {
  if((isset($_GET['url']))||($_SERVER['REQUEST_METHOD'] == 'GET' && count($_GET) == 0)) {
    try {
      $app = new core\App();
    }
    catch(\Error $e) {
      echo $e->getMessage();
    }
  } else {
    try {
      $request = new core\Request();
    }
    catch(\Error $e) {
      echo $e->getMessage();
    }
  }
}
