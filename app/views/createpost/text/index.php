<html>
  <head>
    <title>Create Post</title>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/createpost/style.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/nav.css'>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans" rel="stylesheet">
    <style>
      #postOp {
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

      <textarea id='text' class='fields' name='content' placeholder='Text' maxlength='5000'></textarea>
      <button class='btn' onclick='textPost()'>Post</button>
    </div>

    <script src='/forum/app/views/general/js/navOptions.js'></script>
    <script src='/forum/app/views/createpost/text/main.js'></script>
    <script src='/forum/app/views/createpost/validate.js'></script>
  </body>
</html>
