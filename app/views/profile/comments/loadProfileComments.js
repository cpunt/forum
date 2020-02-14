window.onload = function() {
  loadProfileComments();
}

window.addEventListener('scroll', bottomOfPage);

function bottomOfPage() {
  if((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
    loadProfileComments();
  }
}

function loadProfileComments() {
  const url = window.location.pathname;
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open('GET', `/forum/index.php?loadPosts=${url}`, true);

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const data = JSON.parse(xmlhttp.responseText);

      if(data != undefined && data.length > 0) {
        const createCommentsHTML = new CreateCommentsHTML(data);
        createCommentsHTML.createComments();
      } else {
        window.removeEventListener('scroll', bottomOfPage);
      }
    }
  }

  xmlhttp.send();
}
