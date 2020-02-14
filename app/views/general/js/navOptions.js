function logout() {
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open('POST', '/forum/index.php', true);
  xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      if(xmlhttp.responseText)
        location.reload();
    }
  }

  xmlhttp.send('logout=' + true);
}

function dropDown() {
  const myDropdown = document.getElementById('myDropdown');
  const dropdownDisplay = myDropdown.style.display;

  myDropdown.style.display = dropdownDisplay ? '' : 'block';
}

window.onclick = function (e) {
  if(!e.target.matches('.dropbtn')) {
    const myDropdown = document.getElementById('myDropdown');
    if(myDropdown && myDropdown.style.display) {
      myDropdown.style.display = '';
    }
  }
}
