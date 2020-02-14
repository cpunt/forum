<h4>Make a comment</h4>
<div>
  <textarea id='commentBox' onkeyup='commentBtn()' placeholder='Make a comment'></textarea>
  <button class='btn' id='commentBtn' onclick="newComment('<?= $data['circleName'] ?>', '<?= $data['idpost'] ?>')" disabled='disabled'>Comment</button>
</div>
<h3 id='commentsHeader'>Comments</h3>
