$(document).delegate('#menu-toggle', 'click', function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("active");
});

$(document).delegate('#wrapper.active #page-content-wrapper', 'click', function(e){
  $('#menu-toggle').trigger('click');
});
