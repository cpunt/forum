window.onload = function() {
  loadCircleList();
}

window.addEventListener('scroll', bottomOfPage);

function bottomOfPage() {
  if((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
    loadCircleList();
  }
}

function loadCircleList() {
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.open('GET', `/forum/index.php?loadCircleList=true`, true);

  xmlhttp.onreadystatechange = function() {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      const data = JSON.parse(xmlhttp.responseText);
      const circleDiv = document.getElementById('circleDiv');

      if(data != undefined && data.length > 0) {
        const createCircleHTML = new CreateCircleHTML();

        for(let i = 0; i < data.length; i++) {
          circleDiv.innerHTML += createCircleHTML.getCircleHTML(data[i]);
        }
      } else {
        window.removeEventListener('scroll', bottomOfPage);
      }
    }
  }

  xmlhttp.send();
}

class CreateCircleHTML {

  getCircleHTML(circle) {
    let output = `
    <div class='circle' onclick="viewCircle('${circle.circleName}')">
      <p class='circleName'>c/${circle.circleName}</p>
      <div class='circleInfoCon'>
        <p class='circleInfo'>Created ${circle.circleDate} by <a href='/forum/profile/posts/${circle.username}' >${circle.username}</a></p>
      </div>
    </div>
    `;

    return output;
  }
}
