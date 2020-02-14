<div id='userProfileCon'>
  <a class='userProfileOp' id='profilePosts' href='/forum/profile/posts/<?= $data['username'] ?>'>Posts</a>
  <a class='userProfileOp' id='profileComments' href='/forum/profile/comments/<?= $data['username'] ?>'>Comments</a>
  <?php if($this->userLoggedIn == $data['username']) { ?>
    <a class='userProfileOp' id='profileSaved' href='/forum/profile/saved/<?= $data['username'] ?>'>Saved</a>
  <?php } ?>
</div>
