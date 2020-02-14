function cancel() {
  window.location.href = '/forum/mycircles/created';
}

function update() {
  const description = document.getElementById('des').value.trim();
  const url = window.location.pathname.split('/');
  const circle = url[url.indexOf('edit') + 1];

  const data = {
    'circle': circle,
    'description': description
  };

  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open('PATCH', '/forum/index.php', true);
  xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const data = JSON.parse(xmlhttp.responseText);
      if(data['update']) {
        window.location.href = '/forum/circle/' + data['circle'];
      } else {
        //Error
      }
    }
  }

  xmlhttp.send('updateCircle=' + JSON.stringify(data));
}
