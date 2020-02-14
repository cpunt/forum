window.onload = function() {
  loadPosts();
}

window.addEventListener('scroll', bottomOfPage);

function bottomOfPage() {
  if((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
    loadPosts();
  }
}

function loadPosts() {
  const url = window.location.pathname;
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open('GET', `/forum/index.php?loadPosts=${url}`, true);

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const data = JSON.parse(xmlhttp.responseText);

      if(data != undefined && data.length > 0) {
        const createPostsHTML = new CreatePostsHTML(data);
        createPostsHTML.createPosts();
      } else {
        window.removeEventListener('scroll', bottomOfPage);
      }
    }
  }

  xmlhttp.send();
}
