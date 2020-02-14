<?php
namespace controllers\url;

class Profile extends \core\Controller {
  public function __construct($page='', $username=null) {
    parent::__construct();
    session_start();
    $_SESSION['offset'] = 0;

    $data['username'] = $username;
    $valid = [
      'posts',
      'comments',
      'saved'
    ];

    if($username && in_array($page, $valid)) {
      if($page == 'saved' && $username != $this->userLoggedIn) {
        $this->view('home');
        return;
      }
      $this->view("profile/$page", $data);
    } else {
      $this->view('home');
    }
  }
}
