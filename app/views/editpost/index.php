<html>
  <head>
    <title>Edit Post</title>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/general/css/nav.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/viewpost/css/comment.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/viewpost/css/post.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/viewpost/css/view.css'>
    <link rel='stylesheet' type='text/css' href='/forum/app/views/editpost/edit.css'>
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
      <p id='bannerCN'><a href='/forum/circle/<?= $data['circleName'] ?>'>c/<?= $data['circleName'] ?></a></p>
    </div>

    <div id='centerCon'>
      <div id='postDiv'>
        <p class='user'>Posted on <?= $data['created'] ?> by <a href=''><?= $data['username'] ?></a></p>
        <h5 class='title'><?= $data['title'] ?></h5>
        <textarea id='content' placeholder='text' maxlength='5000'><?= $data['text'] ?></textarea>
        <div id='btns'>
          <button class='editBtn' id='cancel' onclick="cancelEdit('<?= $data['circleName']?>', '<?= $data['idpost'] ?>')">Cancel</button>
          <button class='editBtn' id='update' onclick="updatePost('<?= $data['circleName']?>', '<?= $data['idpost'] ?>')">Save</button>
        </div>

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

    <div id='commentSection'>
      <?php
        $commentSection = "app/views/viewpost/displayCommentSection.php";

        if(file_exists($commentSection)) {
          include $commentSection;
        }
      ?>
    </div>

    <script src='/forum/app/views/viewpost/loadView.js'></script>
    <script src='/forum/app/views/general/js/navOptions.js'></script>
    <script src='/forum/app/views/general/js/memberActions.js'></script>
    <script src='/forum/app/views/general/js/postOptions.js'></script>
    <script src='/forum/app/views/editpost/main.js'></script>
    <script src='/forum/app/views/general/js/commentOptions.js'></script>
  </body>
</html>
