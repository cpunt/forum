<html>
  <head>
    <title>Edit my circle</title>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/nav.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/mycircles/edit/style.css'>
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

    <div id='circleDiv'>
      <h3 class='header'>Description</h3>
      <textarea id='des'><?= $data['circleDescription'] ?></textarea>
      <button onclick='cancel()' class='btn'>Cancel</button>
      <button onclick='update()' class='btn'>Update</button>
      <!-- <p id='count'>${data.circleDescription.length}/200</p> -->
    </div>

    <script src='/forum/app/views/general/js/navOptions.js'></script>
    <script src='/forum/app/views/mycircles/edit/main.js'></script>
  </body>
</html>
