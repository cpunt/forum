window.onload = function() {
  loadProfileSaved();
}

window.addEventListener('scroll', bottomOfPage);

function bottomOfPage() {
  if((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
    loadProfileSaved();
  }
}

function loadProfileSaved() {
  const url = window.location.pathname;
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open('GET', `/forum/index.php?loadPosts=${url}`, true);

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const data = JSON.parse(xmlhttp.responseText);
      const createCommentsHTML = new CreateCommentsHTML(data);
      const createPostsHTML = new CreatePostsHTML(data);
      const postDiv = document.getElementById('divPost');

      if(data != undefined && data.length > 0) {
        for(let i = 0; i < data.length; i++) {
          if(data[i].type != 'comment') {
            postDiv.innerHTML += createPostsHTML.createPost(data[i]);
          } else {
            postDiv.innerHTML += createCommentsHTML.createComment(data[i]);
          }
        }
      } else {
        window.removeEventListener('scroll', bottomOfPage);
      }
    }
  }

  xmlhttp.send();
}
