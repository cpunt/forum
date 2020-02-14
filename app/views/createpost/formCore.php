<div id='optionsCon'>
  <p id='postOp' class='option'><a href='/forum/createpost/text'>Text</a></p>
  <p id='imageOp' class='option'><a href='/forum/createpost/imagevideo'>Image & video</a></p>
  <p id='linkOp' class='option'><a href='/forum/createpost/link'>Link</a></p>
</div>

<form id='searchCircle'>
  <input id='search' class='fields' name='circle' type='text' placeholder='Circles' maxlength='50' list='circlesList' autocomplete='off' value='<?= $data['circle'] ?>'></input>
  <datalist id='circlesList'>
  <?php
    foreach($data['circleList'] as $circle) {
      echo "<option value=$circle />";
    }
  ?>
  </datalist>
</form>

<input type='text' name= 'title' maxlength='50' placeholder='Title' autocomplete='off' id='title' class='fields'></input>
