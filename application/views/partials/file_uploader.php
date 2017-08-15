<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
// Get the template HTML and remove it from the doument
var previewNode = document.querySelector("#template");
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);

var myDropzone = new Dropzone("div.<?=$mod_class;?>", { // Make the whole body a dropzone
url: "/cp/<?=$url;?>", // Set the url
thumbnailWidth: 80,
thumbnailHeight: 80,
parallelUploads: 1,
previewTemplate: previewTemplate,
autoQueue: false, // Make sure the files aren't queued until manually added
previewsContainer: "#previews", // Define the container to display the previews
clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
});

myDropzone.on("success", function(file, response) {
var responseJSON = $.parseJSON(response);
$("#previews, .file-row.dz-success, .progress").html("<p><br>Successfully Imported "+responseJSON.insert
                                                             +" of "+responseJSON.count+" records.</p>");
});

myDropzone.on("addedfile", function(file) {
// Hookup the start button
file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
});

// Update the total progress bar
myDropzone.on("totaluploadprogress", function(progress) {
document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
});

myDropzone.on("sending", function(file) {
// Show the total progress bar when upload starts
document.querySelector("#total-progress").style.opacity = "1";
document.querySelector("#total-progress").style.display = "inherit";
// And disable the start button
file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
});

// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function(progress) {
document.querySelector("#total-progress").style.opacity = "0";
document.querySelector("#total-progress").style.display = "none";
});


// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
document.querySelector("#actions .start").onclick = function() {
myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
};
document.querySelector("#actions .cancel").onclick = function() {
myDropzone.removeAllFiles(true);
};
</script>