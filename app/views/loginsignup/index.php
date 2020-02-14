<?php
  if($this->userLoggedIn) {
    header("Location: http://localhost:8888/forum/home");
    die();
  }

  if($_SERVER['REQUEST_URI'] != '/forum/loginsignup') {
    header("Location: http://localhost:8888/forum/loginsignup");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel='stylesheet' type='text/css' href='http://localhost:8888/forum/app/views/loginsignup/style.css'>
    <link rel='stylesheet' type='text/css' href='http://localhost:8888/forum/app/views/loginsignup/popup.css'>
    <title>User system</title>
  </head>
  <body>


    <div id='logInDiv' class='userDivs'>
      <h3 class='header'>Log In</h3>
      <input type='text' placeholder='Enter username' autocomplete='off'  class='fields loginFields' id='username'>
      <div class='popup'>
        <span class='popuptext' id='popUpLogin'>Incorrect username or password</span>
      </div>
      <input type='password' placeholder='Enter password' class='fields loginFields' id='pw'>
      <input type='submit' onclick='login()'>
    </div>

    <div id='signUpDiv' class='userDivs'>
      <h3 class='header'>Sign up</h3>
      <input type='text' placeholder='Enter username' autocomplete='off' id='newUsername'class='fields signupFields'>
      <div class='popup'>
        <span class='popuptext' id='popUpSignin'>Change to whats wrong and highlight boxes red</span>
      </div>
      <input type='password' placeholder='Enter password' class='fields signupFields' id='newPw'>
      <input type='password' placeholder='Confirm password' class='fields signupFields' id='newCPw'>
      <input type='submit' onclick='signup()'>
    </div>

    <script src='/forum/app/views/loginsignup/main.js'></script>
  </body>
</html>
