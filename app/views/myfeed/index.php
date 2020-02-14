<?php
if(!$this->userLoggedIn) {
  header("Location: http://localhost:8888/forum/home");
  die();
}
?>
<html>
  <head>
    <title>My feed</title>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/posts.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/nav.css'>
    <link href='https://fonts.googleapis.com/css?family=IBM+Plex+Sans' rel='stylesheet'>
  </head>
  <body>

    <?php
      $navbar = "app/views/general/php/navbar.php";
      if(file_exists($navbar)) {
        include $navbar;
      }
    ?>

    <div id='centerCon'>

      <div id='divPost'>
        <h2 class='header'>My feed</h2>


      </div>

      <?php
        $divCreate = "app/views/general/php/divCreate.php";
        if(file_exists($divCreate)) {
          include $divCreate;
        }
      ?>

    </div>

    <script src='/forum/app/views/general/js/CreatePostsHTML.js'></script>
    <script src='/forum/app/views/general/js/navOptions.js'></script>
    <script src='/forum/app/views/general/js/postOptions.js'></script>
    <script src='/forum/app/views/general/js/loadPosts.js'></script>
  </body>
</html>
