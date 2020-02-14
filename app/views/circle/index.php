<html>
  <head>
    <title>c/<?= $data['circleName'] ?></title>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/posts.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/nav.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/circle/style.css'>
    <link href='https://fonts.googleapis.com/css?family=IBM+Plex+Sans' rel='stylesheet'>
  </head>
  <body>

    <?php
      $navbar = "app/views/general/php/navbar.php";
      if(file_exists($navbar)) {
        include $navbar;
      }
    ?>

    <div id='banner'>
      <p id='bannerCN'>c/<?= $data['circleName'] ?></p>
    </div>

    <div id='centerCon'>

      <div id='divPost'>
        <?php if(!$data['circleExists']) { ?>
          <h2 class='header'><?= $data['circleName'] ?> doesn't exist</h2>
        <?php } else {?>
          <h2 class='header'><?= $data['circleName'] ?></h2>
        <?php } ?>
      </div>

      <?php if($data['circleExists']) { ?>
        <div id='otherDiv'>
          <?php
            $memberDiv = "app/views/general/php/memberDiv.php";
            if(file_exists($memberDiv)) {
              include $memberDiv;
            }
          ?>
          <?php
            $divCreate = "app/views/general/php/divCreate.php";
            if(file_exists($divCreate)) {
              include $divCreate;
            }
          ?>
        </div>
      <?php } ?>
    </div>

    <script src='/forum/app/views/general/js/CreatePostsHTML.js'></script>
    <script src='/forum/app/views/general/js/navOptions.js'></script>
    <script src='/forum/app/views/general/js/postOptions.js'></script>
    <script src='/forum/app/views/general/js/memberActions.js'></script>
    <script src='/forum/app/views/general/js/loadPosts.js'></script>
  </body>
</html>
