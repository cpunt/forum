function savePost(id, e) {
  const data = {
    'idpost': id
  };
  data['action'] = e.innerHTML == 'Save' ? 'savePost' : 'unsavePost';
  const verb = e.innerHTML == 'Save' ? 'POST' : 'DELETE';

  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open(verb, `/forum/index.php`, true);
  xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const data = JSON.parse(xmlhttp.responseText);

      if(!data.loggedIn) {
        window.location.href = '/forum/loginsignup'
      } else {
        e.innerHTML = data['saved'];
      }
    }
  }

  xmlhttp.send('postOptions=' + JSON.stringify(data));
}

function deletePost(id) {
  const result = confirm("Are you sure you want to delete this? This can not be undone");
  if(result) {
    const data = {
      'action': 'deletePost',
      'idpost': id
    };

    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open('DELETE', '/forum/index.php', true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xmlhttp.onreadystatechange = function() {
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        const data = JSON.parse(xmlhttp.responseText);

        if(!data.loggedIn) {
          window.location.href = '/forum/loginsignup'
        } else {
          if(data['deleted']) {
            location.reload();
          }
        }
      }
    }
    xmlhttp.send('postOptions=' + JSON.stringify(data));
  }
}

function editPost(circle, id) {
  document.location.href = `/forum/editpost/${circle}/${id}`;
}

function viewPost(circle, id) {
  window.location.href = `/forum/viewpost/${circle}/${id}`;
}
