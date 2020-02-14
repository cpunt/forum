//Comment class start
class Comment {
  constructor(url) {
    this.url = url;
  }

  commentsOptionBar(data) {
    let str = `<div class='commentBar'>
    <p class='replyCom'>Reply</p>`
    if(data.saved) {
      str += `<p class='saveCom'>Unsave</p>`;
    } else {
      str += `<p class='saveCom'>Save</p>`;
    }
    if(data.editable) {
      str += `<p class='deleteCom'>Delete</p>
      <p class='editCom'>Edit</p>`;
    }
    str += `</div>`;

    return str;
  }

  displayComment(data) {
    const postDiv = document.getElementById('divPost');
    postDiv.innerHTML += `
    <div class='commentDiv'>
      <div class='orgPost'>
        <p class='post'>
        <img class='imgBox' src='../../images/comment.png' alt='Comment box' width='20' height='20'>
        <a class='link' href='../?user=${data.username}'>${data.username}</a> commented on
        <a class='link postLink'>${data.title}</a>
        -
        <a class='link' href='${this.url}circles/c/?circle=${data.circleName}'>c/${data.circleName}</a>
        -
        Posted by <a class='link' href='../?user=${data.username}'>${data.username}</a>
        </p>
      </div>
      <div class='commentCon'>
        <p class='userCom posted'>Posted on ${data.postedcom} by <a class='link' href='../?user=${data.usersComment}'>${data.usersComment}</a></p>
        <pre><p class='comment'>${data.comment}</p></pre>
      </div>
      ${this.commentsOptionBar(data)}
    </div>`;
  }
}
//Comment class end
//Comment events start
class CommentEvent {
  constructor(url) {
    this.url = url;
  }

  postLink(data, i) {
    const postLink = document.getElementsByClassName('postLink');
    const commentCon = document.getElementsByClassName('commentCon');
    let query = `${this.url}view/?circle=${data.circleName}&post_id=${data.idpostcom}`;

    postLink[i].addEventListener('click', function() {
      document.location.href = query;
    });

    commentCon[i].addEventListener('click', function() {
      document.location.href = query;
    });
  }

  addEvent(data, i) {
    const save = document.getElementsByClassName('saveCom');

    save[i].addEventListener('click', () => {
      this.saveComment(data.idcomments);
    });

    if(data.editable) {
      const commentDiv = document.getElementsByClassName('commentDiv')[i];
      const commentBar = commentDiv.getElementsByClassName('commentBar')[0];
      const deleteCom = commentBar.getElementsByClassName('deleteCom')[0];
      deleteCom.addEventListener('click', () => {
        this.deleteComment(data.idcomments);
      });
    }
  }

  deleteComment(id) {
    const result = confirm("Are you sure you want to delete this? This can not be undone");
    if(result) {
      const xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          if(xmlhttp.responseText) {
            location.reload();
          }
        }
      }
      xmlhttp.open('GET', `${this.url}ajaxResponses.php?commentActionId=${id}&commentActionType=deleteComment`, true);
      xmlhttp.send();
    }
  }

  saveComment(id) {
    const xmlhttp = new XMLHttpRequest();
    const target = event.target;

    xmlhttp.onreadystatechange = function() {
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        console.log(xmlhttp.responseText);
        if(xmlhttp.responseText === 'saved') {
          target.innerHTML = 'Unsave';
        } else if(xmlhttp.responseText === 'unsaved') {
          target.innerHTML = 'Save';
        }
      }
    }
    xmlhttp.open('GET', `${this.url}ajaxResponses.php?commentActionId=${id}&commentActionType=saveComment`, true);
    xmlhttp.send();
  }
}

//Comments event end
function editable(url='../../ajaxResponses.php') {
  const params = (new URL(document.location)).searchParams;
  const user = params.get('user');
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const data = JSON.parse(xmlhttp.responseText);
      const profileSaved = document.getElementById('profileSaved');

      if(data.user) {
        profileSaved.style.display = 'inline-block';
      } else {
        profileSaved.style.display = 'none';
      }
    }
  }

  xmlhttp.open('GET', url + `?profileEditable=true&profileUser=${user}`, true)
  xmlhttp.send();
}
