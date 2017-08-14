<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="title_left">
    <h3>Configuration Settings</h3>
</div>
<div class="form-group">
    <div class="col-sm-3">
        Set number of days to go back for sale relationship
        <div class="input-group">
            <input type="text" class="form-control">
            <span class="input-group-btn"><button type="button" class="btn btn-primary">Submit</button>
            </span>
<?php
$path = FCPATH.'upload/iis_batch.sh';
$output = exec($path);
var_dump($output);
var_dump($path);

?>
        </div>
    </div>
</div>
