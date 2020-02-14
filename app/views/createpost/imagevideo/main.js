function imageVideoPost() {
  event.preventDefault();

  const submit = document.getElementById('submit');
  const progressBar = document.getElementById('progressBar');
  const progress = document.getElementById('progress');
  const filler = document.getElementById('filler');

  const file = document.getElementById('file').files;
  const formData = new FormData();
  const circle = document.getElementById('search');
  const title = document.getElementById('title');
  const data = {
    'type': 'imageVideo',
    'circle': circle.value,
    'title': title.value
  };

  if(validatePost(circle.value, title.value, 'image/video')) {
    formData.append('createPost', JSON.stringify(data));
    formData.append('file', file[0]);

    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open('POST', '/forum/index.php', true);

    fileProgressBar(xmlhttp);

    xmlhttp.onreadystatechange = function() {
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        const data = JSON.parse(xmlhttp.responseText);

        console.log(data);
        if('created' in data && data['created']) {
          document.location.href = '/forum/profile/posts/' + data['username'];
        } else {
          submit.disabled = false;
          postErrors(data);
        }
      }
    }

    xmlhttp.send(formData);
  }
}

function fileProgressBar(xmlhttp) {
  xmlhttp.onloadstart = function(pe) {
    submit.disabled = true;
    progressBar.style.display = 'block';
  }

  xmlhttp.upload.onprogress = function(pe) {
    if(pe.lengthComputable) {
      let percent = Math.round((pe.loaded / pe.total) * 100);
      progress.innerHTML = `${percent}%`;
      filler.style.width = `${percent}%`;
    }
  }

  xmlhttp.onloadend = function(pe) {
    progress.innerHTML = 'Completed';
    setTimeout(function() {
      progressBar.style.display = 'none';
    }, 1000);
  }
}
