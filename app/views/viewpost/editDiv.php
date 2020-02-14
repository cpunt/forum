<div class='editDiv'>
  <img class='commentImg' src='http://localhost:8888/forum/app/views/general/images/comment.png' alt='comment box' width='15' height='15'>
  <?php
  switch($data['commentCount']) {
    case 0:
      echo "<p class='comments'>Comment</p>";
      break;
    case 1:
      echo "<p class='comments'>1 Comment</p>";
      break;
    default:
      echo "<p class='comments'>$data[commentCount] Comments</p>";
  }
  ?>

  <p class='save' id='savePost'onclick="savePost('<?= $data['idpost'] ?>', this)"><?= $data['saved'] ? 'Unsave' : 'Save'?></p>

  <?php
  if($data['editable']) {
    echo "<p class='delete' onclick='deletePost(`$data[idpost]`)'>Delete</p>";
    if($data['type'] == 'text') {
      echo "<p class='edit' onclick='editPost(`$data[circleName]`, `$data[idpost]`)'>Edit</p>";
    }
  }
  ?>
</div>
