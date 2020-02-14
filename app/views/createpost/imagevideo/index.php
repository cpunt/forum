<html>
  <head>
    <title>Create Post</title>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/createpost/style.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/nav.css'>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans" rel="stylesheet">
    <style>
      #imageOp {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>

    <?php
      $navbar = "app/views/general/php/navbar.php";
      if(file_exists($navbar)) {
        include_once($navbar);
      }
    ?>

    <div id='post'>
      <h2 class='header'>Create a post</h2>

      <?php
        $formCore = "app/views/createpost/formCore.php";
        if(file_exists($formCore)) {
          include_once($formCore);
        }
      ?>

      <div id='fileCon' onsubmit='imageVideoPost()'>
        <form method='post' enctype='multipart/form-data' id='form'>
          <input type='file' name='file' multiple class='btn fields' id='file' accept='image/*, video/*' />
          <input type='submit' value='Post' name='submit' class='btn' id='submit'>
        </form>
      </div>

      <div id='progressBar'>
        <p id='progress'></p>
        <div id='filler'></div>
      </div>
    </div>

    <script src='/forum/app/views/general/js/navOptions.js'></script>
    <script src='/forum/app/views/createpost/imagevideo/main.js'></script>
    <script src='/forum/app/views/createpost/validate.js'></script>
  </body>
</html>
