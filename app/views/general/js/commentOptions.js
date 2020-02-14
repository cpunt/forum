function saveComment(id, e) {
  const data = {
    'idcomment': id
  }

  data['action'] = e.innerHTML == 'Save' ? 'saveComment' : 'unsaveComment';
  const verb = e.innerHTML == 'Save' ? 'POST' : 'DELETE';

  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open(verb, '/forum/index.php', true);
  xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const data = JSON.parse(xmlhttp.responseText);

      if(!data.loggedIn) {
        window.location.href = '/forum/loginsignup'
      } else {
        e.innerHTML = data['text'];
      }
    }
  }

  xmlhttp.send('commentOptions=' + JSON.stringify(data));
}

function deleteComment(id) {
  const result = confirm("Are you sure you want to delete this? This can not be undone");

  if(result) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open('DELETE', '/forum/index.php', true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const data = {
      'action': 'deleteComment',
      'idcomment': id
    }

    xmlhttp.onreadystatechange = function() {
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        const data = JSON.parse(xmlhttp.responseText);

        if(!data.loggedIn) {
          window.location.href = '/forum/loginsignup'
        } else {
          if(data.deleted) {
            location.reload();
          }
        }
      }
    }

    xmlhttp.send('commentOptions=' + JSON.stringify(data));
  }
}

function editComment() {

}

function replyComment() {

}

function commentBtn() {
  const commentBox = document.getElementById('commentBox').value;
  const commentBtn = document.getElementById('commentBtn');

  if(commentBox.length > 0 && commentBtn.disabled) {
    commentBtn.disabled = false;
    commentBtn.style.cursor = 'pointer';
    commentBtn.style.color = 'white';
  } else if(commentBox.length == 0 && !commentBtn.disabled) {
    commentBtn.disabled = true;
    commentBtn.style.cursor = '';
    commentBtn.style.color = '';
  }
}

function newComment(circle, id) {
  const comment = document.getElementById('commentBox').value.trim();
  const data = {
    'action': 'newComment',
    'circle': circle,
    'id': id,
    'comment': comment
  };
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open('POST', '/forum/index.php', true);
  xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const data = JSON.parse(xmlhttp.responseText);

      if(!data.loggedIn) {
        window.location.href = '/forum/loginsignup'
      } else {
        if(data.newComment) {
          location.reload();
        }
      }
    }
  }

  xmlhttp.send('commentOptions=' + JSON.stringify(data));
}
