<div id='memberDiv'>
  <h5 class='details'>Community details</h5>
  <p class='details' id='circleName'><?= $data['circleName'] ?></p>
  <p class='details' id='description'><?= $data['memberDiv']['circleInfo']['circleDescription'] ? $data['memberDiv']['circleInfo']['circleDescription'] : 'No description yet...' ?></p>
  <p class='details' id='memberCount'><?= $data['memberDiv']['memberInfo']['memberCount'] ?> members</p>
  <p class='details' id='createdDate'>Created <?= $data['memberDiv']['circleInfo']['circleDate'] ?></p>
  <button class='circleBtn' id='joinBtn' onclick="joinCircle('<?= $data['circleName'] ?>', this)"><?= $data['memberDiv']['memberInfo']['memberStatus'] ? 'Leave circle' : 'Join circle' ?></button>
</div>
