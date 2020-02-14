<html>
  <head>
    <title>View Post</title>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/nav.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/viewpost/css/comment.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/viewpost/css/post.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/viewpost/css/view.css'>
    <link href='https://fonts.googleapis.com/css?family=IBM+Plex+Sans' rel='stylesheet'>
  </head>
  <body>

    <?php
      $navbar = "app/views/general/php/navbar.php";
      if(file_exists($navbar)) {
        include $navbar;
      }
    ?>

    <?php
    if($data['type'] != 'deleted') {
    ?>
    <div id='banner'>
      <p id='bannerCN'><a href='/forum/circle/<?= $data['circleName'] ?>'>c/<?= $data['circleName'] ?></a></p>
    </div>

    <div id='centerCon'>
      <div id='postDiv'>

        <p class='user'>Posted on <?= $data['created'] ?> by <a href='/forum/profile/posts/<?= $data['username'] ?>'><?= $data['username'] ?></a></p>
        <h5 class='title'><?= $data['title'] ?></h5>
        <?php
          switch($data['type']) {
            case 'text':
              echo "<pre><p class='content'>$data[text]</p></pre>";
              break;
            case 'image':
              echo "<img class='image' src='http://localhost:8888/forum/app/views/general/uploads/$data[text]'>";
              break;
            case 'video':
              echo "<video controls class='vid'>
                      <source src='http://localhost:8888/forum/app/views/general/uploads/$data[text]'</source>
                    </video>";
              break;
            case 'link':
              echo "<a class='linkPost' href='https://$data[text]' target='_blank'>$data[text]</a>";
              break;
          }
        ?>

        <?php
          $editDiv = "app/views/viewpost/editDiv.php";
          if(file_exists($editDiv)) {
            include $editDiv;
          }
         ?>

      </div>

      <?php
        $memberDiv = "app/views/general/php/memberDiv.php";
        if(file_exists($memberDiv)) {
          include $memberDiv;
        }
      ?>
    </div>

    <div id='commentSection' name='commentSection'>
      <?php
        $commentSection = "app/views/viewpost/displayCommentSection.php";

        if(file_exists($commentSection)) {
          include $commentSection;
        }
      ?>
    </div>

    <?php
    } else {
      $deletedPost = "app/views/viewpost/deletedPost.php";

      if(file_exists($deletedPost)) {
        include $deletedPost;
      }
    }
    ?>

    <script src='/forum/app/views/viewpost/loadView.js'></script>
    <script src='/forum/app/views/general/js/navOptions.js'></script>
    <script src='/forum/app/views/general/js/memberActions.js'></script>
    <script src='/forum/app/views/general/js/postOptions.js'></script>
    <script src='/forum/app/views/general/js/commentOptions.js'></script>
  </body>
</html>
