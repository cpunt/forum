<?php

namespace controllers\requests;

class LoadPosts extends \core\Controller {

  public function __construct() {
    parent::__construct();
    $getPostsModel = new \models\posts\GetPostsModel();

    $helper = new \models\helper\HelperModel();
    $iduser = $helper->getUserId($this->userLoggedIn);

    $getPostsOutputModel = new \models\posts\GetPostsOutputModel($iduser, $this->userLoggedIn);

    $url = $_GET['loadPosts'];
    $pages = ['home', 'circle', 'myfeed', 'viewpost', 'editpost', 'posts', 'comments', 'saved'];

    foreach($pages as $page) {
      if(strpos($url, $page)) {
        $currentPage = $page;
      }
    }

    $urlArr = explode('/', $url);
    $index = array_search($currentPage, $urlArr);

    switch($currentPage) {
      case 'home':
        $posts = $getPostsModel->getHomePosts();
        break;
      case 'myfeed':
        if($this->userLoggedIn) {
          $posts = $getPostsModel->getMyFeedPosts($iduser);
        }
        break;
      case 'circle':
        $circleName = $urlArr[$index + 1];
        $posts = $getPostsModel->getCirclePosts($circleName);
        break;
      case 'posts':
      case 'comments':
      case 'saved':
        $userProfile = $urlArr[$index + 1];
        $userProfileId = $helper->getUserId($userProfile);
        $posts = $getPostsModel->getProfile($userProfileId, $currentPage);
        break;
      case 'viewpost':
      case 'editpost':
        $circleName = $urlArr[$index + 1];
        $idpost = $urlArr[$index + 2];
        $posts = $getPostsModel->getViewComments($circleName, $idpost);
        break;
    }

    $postOutput = $posts ? $getPostsOutputModel->getOutput($posts) : $posts;

    echo json_encode($postOutput);
  }
}
