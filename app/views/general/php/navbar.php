<div id='navbar'>
  <div id='mainOptions'>
    <h2 id='forumTitle'>Forum</h2>
    <a href='/forum/home' class='navBtn'>Home</a>
    <a href='/forum/circles' class='navBtn'>Circles</a>
  </div>
    <div id='userOps'>
      <?php if(!$this->userLoggedIn) { ?>
        <a href='/forum/loginsignup' class='login navBtn'>Log in || Sign up</a>
      <?php } else { ?>
        <a class='navBtn' href='/forum/createpost/text'>Post</a>
        <div id='dropdown'>
          <p class='navBtn dropBtn' onclick='dropDown()'>User &#9661;</p>
          <div class='dropdown-content' id='myDropdown'>
            <a class='dropdownBtn' id='profile' href='/forum/profile/posts/<?= $this->userLoggedIn ?>'>My profile</a>
            <a class='dropdownBtn'  href='/forum/myfeed'>My feed</a>
            <a class='dropdownBtn' href='/forum/mycircles/joined'>My circles</a>
            <a class='dropdownBtn' href='#' onclick='logout()'>Logout</a>
          </div>
        </div>
      <?php } ?>
    </div>
</div>
