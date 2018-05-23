<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
// Get the template HTML and remove it from the doument
Dropzone.autoDiscover = false;
var previewNode = document.querySelector("#<?=$mod_class?>");
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);

var <?=$mod_class;?> = new Dropzone("div.<?=$mod_class;?>", { // Make the whole body a dropzone
url: "/cp/<?=$url;?>", // Set the url
acceptedFiles: "<?=$format?>",
autoDiscover:false,
maxFiles:1,
thumbnailWidth: 80,
thumbnailHeight: 80,
parallelUploads: 1,
previewTemplate: previewTemplate,
autoQueue: false, // Make sure the files aren't queued until manually added
previewsContainer: "#previews-<?=$mod_class?>", // Define the container to display the previews
clickable: ".fileinput-button-<?=$mod_class;?>", // Define the element that should be used as click trigger to select files.
});

<?=$mod_class;?>.on("error", function(file, response) {
    console.log(response);
});


<?=$mod_class;?>.on("success", function(file, response) {
var responseJSON = $.parseJSON(response);
$(".progress-striped-<?=$mod_class;?>").html("Successfully Imported "+responseJSON.insert
                                                             +" of "+responseJSON.count+" records.");
});

<?=$mod_class;?>.on("addedfile", function(file) {
// Hookup the start button
file.previewElement.querySelector(".start-<?=$mod_class;?>").onclick = function() { <?=$mod_class;?>.enqueueFile(file); };
document.querySelector(".fileinput-button-<?=$mod_class;?>").style.display = "none";
});

// Update the total progress bar
<?=$mod_class;?>.on("totaluploadprogress", function(progress) {
document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
});

<?=$mod_class;?>.on("sending", function(file) {
// Show the total progress bar when upload starts
document.querySelector("#total-progress").style.opacity = "1";
document.querySelector("#total-progress").style.display = "inherit";
// And disable the start button
file.previewElement.querySelector(".start-<?=$mod_class;?>").setAttribute("disabled", "disabled");
});

// Hide the total progress bar when nothing's uploading anymore
<?=$mod_class;?>.on("queuecomplete", function(progress) {
document.querySelector("#total-progress").style.opacity = "0";
document.querySelector("#total-progress").style.display = "none";
});


// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
document.querySelector("#actions .start-<?=$mod_class;?>").onclick = function() {
<?=$mod_class;?>.enqueueFiles(<?=$mod_class;?>.getFilesWithStatus(Dropzone.ADDED));
};
document.querySelector("#actions .cancel-<?=$mod_class;?>").onclick = function() {
document.querySelector(".fileinput-button-<?=$mod_class;?>").style.display = "inline-block";
<?=$mod_class;?>.removeAllFiles(true);
};
</script>