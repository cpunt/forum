<?php
namespace core;

class Request {
  private $keys;
  //Maybe on construct init key & verb to property
  public function __construct() {
    $action = $_SERVER['REQUEST_METHOD'];
    $this->keys = $this->keys();
    $key = $this->key($action);

    if(file_exists('app/controllers/requests/'. $key . '.php')) {
      $className = "\controllers\\requests\\$key";
      $class = new $className();
    }
  }

  private function key($action) {
    switch($action) {
      case 'POST':
      case 'GET':
        $verb = $action == 'POST' ? $_POST : $_GET;
        break;
      case 'DELETE':
      case 'PATCH':
        $verb = [];
        parse_str(file_get_contents("php://input"), $verb);
        break;
      default:
        $verb = null;
    }

    foreach($this->keys[$action] as $value) {
      if(array_key_exists($value, $verb)) {
        $key = $value;
        break;
      }
    }

    return $key;
  }

  private function keys() {
    return [
      'POST' => [
        'userCredentials',
        'logout',
        'circleAction',
        'postOptions',
        'commentOptions',
        'createPost',
        'createCircle'
      ],
      'GET' => [
        'loadPosts',
        'loadCircleList'
      ],
      'DELETE' => [
        'postOptions',
        'commentOptions',
        'circleAction'
      ],
      'PATCH' => [
        'postOptions',
        'commentOptions',
        'updateCircle'
      ]
    ];
  }
}
