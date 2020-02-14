<div id='banner'>
  <p id='bannerCN'><a href='/forum/circle/<?= $data['circleName'] ?>'>c/<?= $data['circleName'] ?></a></p>
</div>

<div id='centerCon'>
  <div id='postDiv'>
    <h5 class='title'><?= $data['title'] ?></h5>
  </div>

  <?php
    $memberDiv = "../app/views/general/php/memberDiv.php";
    if(file_exists($memberDiv)) {
      include $memberDiv;
    }
  ?>
</div>

<div id='commentSection' name='commentSection'></div>
