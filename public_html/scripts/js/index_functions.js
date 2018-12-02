var switcher = 0;

function div_hide() {
    document.getElementById("formParent").style.display = "none"
}

var validExt = ".mp3,.wav,.flac,.ogg";

function fileExtValidate(e) {
    var t = e.value;
    "string" == typeof e && (t = e);
    var l = t.substring(t.lastIndexOf(".") + 1).toLowerCase();
    return !(validExt.indexOf(l) < 0 && (alert("This file is not allowed, (.mp3,.flac,.wav,.ogg))."), 1))
}
var maxSize = "131072";

function fileSizeValidate(e) {
    var t;
    return e.files && e.files[0] ? !((t = e.files[0].size / 1024) > maxSize && (alert("Maximum file size allowed is 128MB, This file size is: " + (t/1024) + "MB"), 1)) : e ? !((t = e.size / 1024) > maxSize && (alert("Maximum file size allowed is 128MB, This file size is: " + (t/1024) + "MB"), 1)) : void 0
}

$(document).ready(function(){
  $('input[type=file]').change(function(){
    if(fileExtValidate(this)) {
      if(fileSizeValidate(this)) {
        $(this).simpleUpload("upload.php", {
          start: function(file){
            $('#progress').html("");
            $('#progressBar').width(0);
          },
          progress: function(progress){
            $('#progress').html("Progress: " + Math.round(progress) + "%");
            $('#progressBar').width(progress + "%");
          },
          success: function(data){
            $('#progress').html("Success!");
            document.getElementById("textDisplay").innerHTML = data;
          },
          error: function(error){
            $('#progress').html("Failure!<br>" + error.name + ": " + error.message);
          }
        });
      }
    }
  });
  $('.drop-field').on("dragleave mouseleave", function(event) {
      event.preventDefault();
      event.stopPropagation();
      $('.drop-field').attr('style','height:10em;width:15em;border: 1px dashed gray;position: relative;');
    });
  $('.drop-field').on("dragover mouseenter", function(event) {
      event.preventDefault();
      event.stopPropagation();
      $('.drop-field').attr('style','height:10em;width:15em;border: 5px dashed red;position: relative;');
    });
  $('.drop-field').on("drop", function(event) {
      event.preventDefault();
      event.stopPropagation();
      var filevar = event.originalEvent.dataTransfer.files[0];
      var formData = new FormData();
      formData.append("file", filevar);
      if(fileExtValidate(filevar.name))
      {
        if(fileSizeValidate(filevar)){
          $.ajax({
            url: 'upload.php',
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
              $('#progress').html("Success!");
              document.getElementById("textDisplay").innerHTML = data;
            }
          });
        }
      }
      $('.drop-field').attr('style','height:10em;width:15em;border: 1px dashed gray;position: relative;');
    });
});
