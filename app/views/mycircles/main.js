function viewCircle(circle) {
  window.location.href = `/forum/circle/${circle}`;
}

function editCircle(circle) {
  event.stopPropagation();

  window.location.href = `/forum/mycircles/edit/${circle}`;
}
