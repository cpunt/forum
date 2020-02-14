class CreateCommentsHTML {
  constructor(comments) {
    this.comments = comments;
  }

  createComments() {
    const postDiv = document.getElementById('divPost');

    for(let i = 0; i < this.comments.length; i++) {
      postDiv.innerHTML += this.createComment(this.comments[i]);
    }
  }

  createComment(comment) {
    let saved = comment.saved ? 'Unsave' : 'Save';
    let commentHTML = `
    <div class='commentDiv'>
      <div class='orgPost'>
        <p class='post'>
          <img class='imgBox' src='http://localhost:8888/forum/app/views/general/images/comment.png' alt='Comment box' width='20' height='20'>
          <a class='linkCom' href='/forum/profile/posts/${comment.username}'>${comment.username}</a> commented on
          <a class='linkCom postLink' href='/forum/viewpost/${comment.circleName}/${comment.idpost}'>${comment.title}</a>
          -
          <a class='linkCom' href='/forum/circle/${comment.circleName}'>c/${comment.circleName}</a>
          -
          Posted by <a class='linkCom' href='/forum/profile/posts/${comment.postUsername}'>${comment.postUsername}</a>
        </p>
      </div>
      <div class='commentCon'>
        <p class='userCom posted'>Posted on ${comment.created} by <a class='linkCom' href='/forum/profile/posts/${comment.username}'>${comment.username}</a></p>
        <pre><p class='comment'>${comment.text}</p></pre>
      </div>
      <div class='commentBar'>
        <p class='replyCom'>Reply</p>
        <p class='saveCom' onclick="saveComment('${comment.idcomment}', this)">${saved}</p>
    `;

    if(comment.editable) {
      commentHTML += `
      <p class='deleteCom' onclick="deleteComment('${comment.idcomment}')">Delete</p>
      <p class='editCom'>Edit</p>
      `;
    }

    commentHTML += `
      </div>
    </div>
    `;

    return commentHTML;
  }
}
