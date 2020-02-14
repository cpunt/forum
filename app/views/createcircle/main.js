function createCircle() {
  const circleName = document.getElementById('circleName');
  const circleDescription = document.getElementById('circleDescription');
  const data = {
    'circle': circleName.value,
    'description': circleDescription.value,
  };

  const errors = {};
  const regex = /^[a-z0-9]+$/i;
  const circleNameLength = circleName.value.length;
  const descriptionLength = circleDescription.value.length;

  if(circleNameLength < 3 || circleNameLength > 50) {
    errors['circleLen'] = true;
  }

  if(!regex.test(circleName.value)) {
    errors['alphaNum'] = true;
  }

  if(descriptionLength > 200) {
    errors['descriptionLen'] = true;
  }

  if(Object.keys(errors).length != 0) {
    circleCreationErrors(errors);
    return;
  }

  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open('POST', '/forum/index.php', true);
  xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const data = JSON.parse(xmlhttp.responseText);
      console.log(data);
      if(data['error']) {
        circleCreationErrors(data);
      } else {
        window.location.href = '/forum/circle/' + data['circle'];
      }
    }
  }


  xmlhttp.send(`createCircle=${JSON.stringify(data)}`);
}

function circleCreationErrors(errors) {
  const circleName = document.getElementById('circleName');
  const circleDescription = document.getElementById('circleDescription');
  const inputFields = document.getElementsByClassName('inputFields');

  for(let i = 0; i < inputFields.length; i++) {
    inputFields[i].style.borderColor = '';
  }

  if('circleLen' in errors || 'alphaNum' in errors || 'circleTaken' in errors) {
    circleName.style.borderColor = 'red';
  }

  if('descriptionLen' in errors) {
    circleDescription.style.borderColor = 'red';
  }
}
