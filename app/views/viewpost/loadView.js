window.onload = function() {
  loadComments();
}

window.addEventListener('scroll', bottomOfPage);

function bottomOfPage() {
  if((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
    loadComments();
  }
}

function loadComments() {
  const url = window.location.pathname;
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open('GET', `/forum/index.php?loadPosts=${url}`, true);

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const data = JSON.parse(xmlhttp.responseText);
      const commentSection = document.getElementById('commentSection');
      const createCommentHTML = new CreateCommentHTML();

      if(data != undefined && data.length > 0) {
        for(let i = 0; i < data.length; i++) {
          commentSection.innerHTML += createCommentHTML.getCommentHTML(data[i]);
        }
      } else {
        window.removeEventListener('scroll', bottomOfPage);
      }
    }
  }

  xmlhttp.send();
}

class CreateCommentHTML {

  getCommentHTML(comment) {
    const saved = comment.saved ? 'Unsave' : 'Save';
    let output = `
    <div class='commentDiv'>
      <div class='commentCon'>
        <p class='userCom posted'>Posted on ${comment.created} by <a class='linkCom' href='/forum/profile/posts/${comment.username}'>${comment.username}</a></p>
        <pre><p class='comment'>${comment.text}</p></pre>
      </div>
      <div class='commentBar'>
        <p class='replyCom'>Reply</p>
        <p class='saveCom' onclick="saveComment('${comment.idcomment}', this)">${saved}</p>
    `;

    if(comment.editable) {
      output += `
      <p class='deleteCom' onclick="deleteComment('${comment.idcomment}')">Delete</p>
      <p class='editCom'>Edit</p>
      `;
    }

    output += `
      </div>
    </div>
    `;

    return output;
  }
}
