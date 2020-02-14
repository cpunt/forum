function validatePost(circle, title, post) {
  const errors = {};
  const circleLen = circle.length;
  const titleLen = title.length;

  if(circleLen == 0 || circleLen > 50) {
    errors['circle'] = true;
  }

  if(titleLen == 0 || titleLen > 100) {
    errors['title'] = true;
  }

  switch(post) {
      case 'text':
        const content = document.getElementById('text').value;
        const contentLen = content.length;

        if(contentLen == 0 || contentLen > 5000) {
          errors['content'] = true;
        }
        break;
      case 'link':
        const link = document.getElementById('link').value;
        const linkLen = link.length;

        if(linkLen == 0 || linkLen > 2000) {
          errors['link'] = true;
        }
        break;
      case 'image/video':
        const file = document.getElementById('file').files;
        const fileLength = file.length;
        if(fileLength != 1) {
          errors['file'] = true;
        }
        break;
  }

  if(Object.entries(errors).length === 0) {
    return true;
  } else {
    postErrors(errors);
    return false;
  }
}

function postErrors(errors) {
  const fields = document.getElementsByClassName('fields');

  for(let i = 0; i < fields.length; i++) {
    fields[i].style.borderColor = '';

    if(fields[i].name in errors) {
       fields[i].style.borderColor = 'red';
     }
  }
}
