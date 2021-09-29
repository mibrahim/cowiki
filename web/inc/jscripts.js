var editing = false;
function edit() {
  editing = true;
  tinymce.init({
    selector: '#basic-conf',
    plugins: [
      'advlist autolink link image lists charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks code fullscreen insertdatetime media nonbreaking',
      'table emoticons template paste help'
    ],
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullpage | ' +
      'forecolor backcolor emoticons | help',
    menu: {
      favs: {
        title: 'My Favorites',
        items: 'code visualaid | searchreplace | emoticons'
      }
    },
    height: "600",
    menubar: 'favs file edit view insert format tools table help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
  });
}

function modalDialog(title, htmlContents) {
  var html =
    "<div class='modal fade bd-modal-sm' tabindex = '-1' role = 'dialog'" +
    " aria-hidden='true' id='modaldlgid'>" +
    "        <div class='modal-dialog modal-sm'>" +
    "            <div class='modal-content'>" +
    "               <div class='modal-header'>" +
    "                   <h5 class='modal-title'>" + title + "</h5>" +
    "                   <button type='button' id='modalclose' class='close' data-dismiss='modal' aria-label='Close'> " +
    "                       <span aria-hidden='true'>&times;</span> " +
    "                   </button> " +
    "               </div>" +
    "               <div class='modal-body'>" +
    "                   " + htmlContents +
    "               </div>" +
    "               <div class=\"modal-footer\">" +
    "                   <button type=\"button\" id='closebutton' class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>" +
    "               </div>" +
    "            </div>" +
    "        </div>" +
    "</div>";

  $(html)
    .appendTo('body');

  var myModal = new bootstrap.Modal(document.getElementById("modaldlgid"), {});
  myModal.show();
  $('#modalclose').click(
    function () {
      myModal.hide();
      $("#modaldlgid").remove();
    });
  $('#closebutton').click(
    function () {
      myModal.hide();
      $("#modaldlgid").remove();
    });
}

function newPage(site) {
  var html = "\
<form method='post'>\
<input type='hidden' id='todoid' name='todo' value='newpage'>\
<div class='form-group'>\
  <label for='site'>Site</label>\
  <input type='text' class='form-control' id='siteid' name='sitename' value='"+ htmlEncode(site) + "'>\
</div>\
<div class='form-group'>\
  <label for='site'>Title</label>\
  <input type='text' class='form-control' id='titleid' name='title' placeholder='Enter page title'>\
</div>\
<div class='form-group'>\
  <br/>\
  <input type='submit' class='btn btn-success' id='titleid' value='create page'>\
</div>\
</form>";

  modalDialog("Add new page", html);
}

function reparent() {
  var html = "\
<form method='post'>\
<input type='hidden' id='todoid' name='todo' value='reparent'>\
<div class='form-group'>\
  <label for='site'>New parent ID</label>\
  <input type='text' class='form-control' id='newparent' name='newparent' value=''>\
</div>\
<div class='form-group'>\
  <br/>\
  <input type='submit' class='btn btn-success' id='titleid' value='reparent'>\
</div>\
</form>";

  modalDialog("Add new page", html);
}

function childPage(site, parent, parentid) {
  var html = "\
<form method='post'>\
  <input type='hidden' id='todoid' name='todo' value='childpage'>\
  <div class='form-group'>\
    <label for='site'>Site</label>\
    <input type='text' class='form-control' id='siteid' name='sitename' value='"+ htmlEncode(site) + "' readonly>\
  </div>\
  <div class='form-group'>\
    <label for='site'>Title</label>\
    <input type='text' class='form-control' id='titleid' name='title' placeholder='Enter page title'>\
  </div>\
  <div class='form-group'>\
    <label for='site'>Parent page</label>\
    <input type='text' class='form-control' id='parentname' value='"+ htmlEncode(parent) + "' readonly>\
    <input type='hidden' class='form-control' id='parentid' name='parentid' value='"+ parentid + "'>\
  </div>\
  <div class='form-group'>\
    <br/>\
    <input type='submit' class='btn btn-success' id='titleid' value='create page'>\
  </div>\
</form>";

  modalDialog("Add a child page", html);
}

function edittitle(title) {
  var html = "\
<form method='post'>\
  <input type='hidden' id='todoid' name='todo' value='updatetitle'>\
  <div class='form-group'>\
    <label for='site'>Title</label>\
    <input type='text' class='form-control' id='titleid' name='title' value='"+ htmlEncode(title) + "' placeholder='Enter page title'>\
  </div>\
  <div class='form-group'>\
    <br/>\
    <input type='submit' class='btn btn-success' id='titleid' value='update'>\
  </div>\
</form>";

  modalDialog("Edit title", html);
}

function save() {
  if (!editing) return;

  var content = tinymce.get("basic-conf").getContent();

  $.post(
    window.location,
    {
      todo: "updatecontent",
      content: content
    }
  ).done(function (data) {
    window.location.reload()
  });
}

function htmlDecode(value) {
  return $("<textarea/>").html(value).text();
}

function htmlEncode(value) {
  return value.replace('"', '&quot;').replace("'", '&apos;');
}