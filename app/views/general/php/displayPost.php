<?php
function displayPost($post) {
?>
  <div class='postCon'>
    <div class='postSection' onclick="viewPost('<?= $post['circleName']?>',<?= $post['id'] ?>)">
      <p class='circle'><a href='/forum/circle/<?= $post['circleName'] ?>'>c/<?= $post['circleName'] ?></a></p>
      <p class='user'>Posted on <?= $post['posted'] ?> by <a href='/forum/profile/posts/<?= $post['username'] ?>'><?= $post['username'] ?></a></p>
      <h5 class='title'><?= $post['title'] ?></h5>
      <?php
        switch($post['type']) {
          case 'text':
            echo "<pre><p class='content'>$post[content]</p></pre>";
            break;
          case 'image':
            echo "<img class='image' src='/forum/app/views/general/uploads/$post[file_name]'>";
            break;
          case 'video':
            echo "<video class='vid' controls>
                <source src='/forum/app/views/general/uploads/$post[file_name]'</source>
              </video>";
            break;
          case 'link':
            echo "<a class='link' onclick='event.stopPropagation()' href='https://$post[link]' target='_blank'>$post[link]</a>";
            break;
        }
      ?>
    </div>
    <div class='editDiv'>
      <img class='commentImg' src='/forum/app/views/general/images/comment.png' alt='comment box' width='15' height='15'>
      <?php
        switch($post['commentCount']) {
          case 0:
            $html = 'Comment';
            break;
          case 1:
            $html = '1 Comment';
            break;
          default:
            $html = "$post[commentCount] Comments";
            break;
        }
      ?>

      <p class='comments'><a href="/forum/viewpost/<?= $post['circleName'] ?>/<?= $post['id'] ?>/#commentSection"><?= $html ?></a></p>
      <p class='save' id='savePost'onclick='savePost(<?= $post[id] ?>, this)'><?= $post['saved'] ? 'Unsave' : 'Save'?></p>

      <?php
      if($post['editable']) {
        echo "<p class='delete' onclick='deletePost($post[id])'>Delete</p>";
        if($post['type'] == 'text') {
          echo "<p class='edit' onclick='editPost(`$post[circleName]`, $post[id])'>Edit</p>";
        }
      }
      ?>
    </div>
  </div>
<?php
}
?>
