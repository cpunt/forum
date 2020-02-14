class CreatePostsHTML {
  constructor(posts) {
    this.posts = posts;
  }

  createPosts() {
    const postDiv = document.getElementById('divPost');

    for(let i = 0; i < this.posts.length; i++) {
      postDiv.innerHTML += this.createPost(this.posts[i]);
    }
  }

  createPost(post) {
    let saved = post.saved ? 'Unsave' : 'Save';
    let html;

    let postHTML =`
    <div class='postCon'>
      <div class='postSection' onclick="viewPost('${post.circleName}', '${post.idpost}')">
        <p class='circle'><a href='/forum/circle/${post.circleName}'>c/${post.circleName}</a></p>
        <p class='user'>Posted on ${post.created} by <a href='/forum/profile/posts/${post.username}'>${post.username}</a></p>
        <h5 class='title'>${post.title}</h5>
    `;

    switch(post.type) {
      case 'text':
        postHTML += `<pre><p class='content'>${post.text}</p></pre>`;
        break;
      case 'image':
        postHTML +=  `<img class='image' src='/forum/app/views/general/uploads/${post.text}'>`;
        break;
      case 'video':
        postHTML += `
        <video class='vid' controls>
          <source src='/forum/app/views/general/uploads/${post.text}'</source>
        </video>
        `;
        break;
      case 'link':
        postHTML += `<a class='link' onclick='event.stopPropagation()' href='${post.text}' target='_blank'>${post.text}</a>`;
        break;
    }

    postHTML += `
    </div>
    <div class='editDiv'>
      <img class='commentImg' src='/forum/app/views/general/images/comment.png' alt='comment box' width='15' height='15'>
    `;

    switch(post.commentCount) {
      case 0:
        html = `Comment`;
        break;
      case 1:
        html = `1 Comment`;
        break;
      default:
        html = `${post.commentCount} Comments`;
        break;
    }

    postHTML += `
    <p class='comments'><a href="/forum/viewpost/${post.circleName}/${post.idpost}/#commentSection">${html}</a></p>
    <p class='save' id='savePost'onclick="savePost('${post.idpost}', this)">${saved}</p>
    `;

    if(post.editable) {
      postHTML += `<p class='delete' onclick="deletePost('${post.idpost}')">Delete</p>`;

      if(post.type == 'text') {
        postHTML += `<p class="edit" onclick="editPost('${post.circleName}', '${post.idpost}')">Edit</p>`;
      }
    }

    postHTML += `
      </div>
    </div>
    `;

    return postHTML;
  }
}
