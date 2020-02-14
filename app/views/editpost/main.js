function cancelEdit(circle, id) {
  document.location.href = `/forum/viewpost/${circle}/${id}`;
}

function updatePost(circle, id) {
  const content = document.getElementById('content').value.trim();
  const data = {
    'action': 'updatePost',
    'idpost': id,
    'content': content
  };

  if(content.length > 5000) {
    contentWarning();
  } else {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open('PATCH', '/forum/index.php', true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xmlhttp.onreadystatechange = function() {
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        const data = JSON.parse(xmlhttp.responseText);

        if(!data.loggedIn) {
          window.location.href = '/forum/loginsignup'
        } else {
          if(data['updated']) {
            document.location.href = `/forum/viewpost/${circle}/${id}`;
          } else {
            contentWarning();
          }
        }
      }
    }

    xmlhttp.send('postOptions=' + JSON.stringify(data));
  }
}

function contentWarning() {
  const content = document.getElementById('content');
  content.style.borderColor = 'red';
}
