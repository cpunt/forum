<html>
  <head>
    <title>My circles joined</title>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/circleList.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/nav.css'>
    <link href='https://fonts.googleapis.com/css?family=IBM+Plex+Sans' rel='stylesheet'>
    <style>
      #joined {
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

    <div id='userProfileCon'>
      <a class='userProfileOp' id='joined' href='#'>Joined Circles</a>
      <a class='userProfileOp' id='created' href='/forum/mycircles/created'>Created Circles</a>
    </div>

    <div id='circleDiv'>
      <?php
        if($data) {
      ?>
          <h2 class='header'>My circles joined</h2>
      <?php
          foreach($data as $circle) {
      ?>
        <div class='circle' onclick="viewCircle('<?= $circle['circleName'] ?>')">
          <p class='circleName'>c/<?= $circle['circleName'] ?></p>
          <div class='circleInfoCon'>
            <p class='circleInfo'>Created <?= $circle['circleDate'] ?> by <a href='/forum/public/profile/posts/?<?= $circle['username'] ?>' ><?= $circle['username'] ?></a></p>
          </div>
        </div>
      <?php
          }
        } else {
      ?>
        <h2 class='header'>No circles joined yet...</h2>
      <?php
        }
      ?>
    </div>

    <script src='/forum/app/views/general/js/navOptions.js'></script>
    <script src='/forum/app/views/mycircles/main.js'></script>
  </body>
</html>
