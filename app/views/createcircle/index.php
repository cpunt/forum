<html>
  <head>
    <title>Create circle</title>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/createcircle/style.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/nav.css'>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans" rel="stylesheet">
  </head>
  <body>

    <?php
      $navbar = "app/views/general/php/navbar.php";
      if(file_exists($navbar)) {
        include $navbar;
      }
    ?>

    <div id='circleDiv'>
      <h2 class='header'>Create a circle</h2>
      <input id='circleName' class='inputFields' maxlength='50' placeholder='Circle name' autocomplete='off'></input>
      <textarea id='circleDescription' class='inputFields' maxlength='200' placeholder='Add description about circle'></textarea>
      <button class='btn' onclick='createCircle()'>Create circle</button>
    </div>

    <script src='/forum/app/views/createcircle/main.js'></script>
    <script src='/forum/app/views/general/js/navOptions.js'></script>
  </body>
</html>
