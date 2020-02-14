<?php
namespace core;
//This will deal with parameters
Class App {
  protected $controller = 'home';

  public function __construct() {
    $url = $this->parseURL();

    if(file_exists('app/controllers/url/' . $url[0] . '.php')) {
      $this->controller = $url[0];
      unset($url[0]);
    }

    $arguments = array_values($url);

    $className = "\controllers\url\\$this->controller";
    $this->controller = new $className(...$arguments);
  }

  protected function parseUrl() {
    if(isset($_GET['url'])) {
      return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    }
  }
}
