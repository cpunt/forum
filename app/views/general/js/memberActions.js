function joinCircle(circle, e) {
  const data = {
    'circle': circle
  };
  data['action'] = e.innerHTML == 'Join circle' ? 'joinCircle' : 'leaveCircle';
  const verb = e.innerHTML == 'Join circle' ? 'POST' : 'DELETE';

  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open(verb, '/forum/index.php', true);
  xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const data = JSON.parse(xmlhttp.responseText);
      const memberCount = document.getElementById('memberCount');

      if(!data.loggedIn) {
        window.location.href = '/forum/loginsignup';
      } else {
        memberCount.innerHTML = `${data['members']} members`;
        e.innerHTML = data['status'];
      }
    }
  }

  xmlhttp.send('circleAction=' + JSON.stringify(data));
}
