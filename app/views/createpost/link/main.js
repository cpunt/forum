function linkPost() {
  const circle = document.getElementById('search');
  const title = document.getElementById('title');
  const link = document.getElementById('link');
  const data = {
    'type': 'link',
    'circle': circle.value,
    'title': title.value,
    'text': link.value
  };

  if(validatePost(circle.value, title.value, 'link')) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open('POST', '/forum/index.php', true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xmlhttp.onreadystatechange = function() {
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        const data = JSON.parse(xmlhttp.responseText);
        if('created' in data && data['created']) {
          document.location.href = '/forum/profile/posts/' + data['username'];
        } else {
          postErrors(data);
        }
      }
    }

    xmlhttp.send(`createPost=${JSON.stringify(data)}`);
  }
}
