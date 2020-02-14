<html>
  <head>
    <title>Circles</title>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/circleList.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/nav.css'>
    <link href='https://fonts.googleapis.com/css?family=IBM+Plex+Sans' rel='stylesheet'>
    <style>
      #divCreate, #circleDiv {
        display: inline-block;
        vertical-align: top;
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

    <div id='centerCon'>
      <div id='circleDiv'>
        <h2 class='header'>Circles</h2>
      </div>

      <?php
        $divCreate = "app/views/general/php/divCreate.php";
        if(file_exists($divCreate)) {
          include $divCreate;
        }
      ?>
    </div>

    <script src='/forum/app/views/circles/loadCircleList.js'></script>
    <script src='/forum/app/views/general/js/navOptions.js'></script>
    <script src='/forum/app/views/mycircles/main.js'></script>
  </body>
</html>
