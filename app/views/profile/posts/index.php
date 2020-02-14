<html>
  <head>
    <title><?= $data['username'] ?> posts</title>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/profile/style.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/nav.css'>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans" rel="stylesheet">
    <style>
      #profilePosts {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>

    <?php
      $navbar = "app/views/general/php/navbar.php";
      if(file_exists($navbar)) {
        include $navbar;
      }
    ?>

    <?php
      $userProfileCon = "app/views/profile/userProfileCon.php";
      if(file_exists($userProfileCon)) {
        include $userProfileCon;
      }
    ?>

    <div id='divPost'>
      <h2 class='header'><?= $data['username'] ?>- posts</h2>
    </div>

    <script src='/forum/app/views/general/js/CreatePostsHTML.js'></script>
    <script src='/forum/app/views/general/js/loadPosts.js'></script>
    <script src='/forum/app/views/general/js/navOptions.js'></script>
    <script src='/forum/app/views/general/js/postOptions.js'></script>
  </body>
</html>
