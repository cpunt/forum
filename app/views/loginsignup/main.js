function login() {
  const username = document.getElementById('username').value.trim();
  const pw = document.getElementById('pw').value;
  const popup = document.getElementById('popUpLogin');
  const fields = document.getElementsByClassName('loginFields');
  for(let i = 0; i < fields.length; i++) {
    fields[i].style.borderColor = '';
  }

  if(popup.classList.toggle('show'))
    popup.classList.toggle('show');

  const data = {
    'action': 'login',
    'username': username,
    'pw': pw
  };

  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open('POST', 'index.php', true);
  xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const res = JSON.parse(xmlhttp.responseText);

      if(res['login']) {
        window.location.href = 'home';
      } else {
        const fields = document.getElementsByClassName('loginFields');
        for(let i = 0; i < fields.length; i++) {
          fields[i].style.borderColor = 'red';
        }

        popup.classList.toggle('show');
      }
    }
  }

  xmlhttp.send('userCredentials=' + JSON.stringify(data));
}

function signup() {
  const username = document.getElementById('newUsername').value.trim();
  const pw = document.getElementById('newPw').value;
  const cPw = document.getElementById('newCPw').value;
  const data = {
    'action': 'signup',
    'username': username,
    'pw': pw,
    'cPw': cPw
  };

  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open('POST', 'index.php', true);
  xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const res = JSON.parse(xmlhttp.responseText);

      if(res['login']) {
        window.location.href = 'home';
      } else {
        validate(res.validUsername, res.usernameFree, res.validPassword, res.matchingPasswords);
      }
    }
  }

  xmlhttp.send('userCredentials=' + JSON.stringify(data));
}

function validate(validUsername, usernameFree, validPassword, matchingPasswords) {
  const username = document.getElementById('newUsername');
  const pw = document.getElementById('newPw');
  const cPw = document.getElementById('newCPw');
  const fields = document.getElementsByClassName('signupFields');
  const popup = document.getElementById('popUpSignin');

  for(let i = 0; i < fields.length; i++) {
    fields[i].style.borderColor = '';
  }

  if(popup.classList.toggle('show'))
    popup.classList.toggle('show');

  popup.innerHTML = '';

  if(!validUsername) {
    popup.innerHTML += "*Username needs to be alpha numeric.<br>";
    username.style.borderColor = 'red';
  } else if(!usernameFree) {
    popup.innerHTML += "*Username is taken.<br>";
    username.style.borderColor = 'red';
  }

  if(!validPassword) {
    popup.innerHTML += "*Invalid password, requirements: -1+ uppercase letter<br> -1+ lowercase letter<br> -1+ numbers<br> -minimum 6 characters<br>";
    pw.style.borderColor = 'red';
  }

  if(!matchingPasswords) {
    popup.innerHTML += "*Passwords do not match.<br>"
    cPw.style.borderColor = 'red';
  }

  popup.classList.toggle('show');
}
