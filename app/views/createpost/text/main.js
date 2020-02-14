function textPost() {
  const circle = document.getElementById('search');
  const title = document.getElementById('title');
  const content = document.getElementById('text');
  const data = {
    'type': 'text',
    'circle': circle.value,
    'title': title.value,
    'text': content.value
  };

  if(validatePost(circle.value, title.value, 'text')) {
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
