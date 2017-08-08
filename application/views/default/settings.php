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
use Gumbercules\IisLogParser\LogFile;

//create an instance of \SplFileObject to inject into LogFile
$pathToFile = FCPATH."upload/iis_logs/test.log";

$file = new \SplFileObject($pathToFile);

//create instance of LogFile using \SplFileObject
$logFile = new LogFile($file);
//you will now have an array of LogEntry objects available via LogFile's getEntries() method
$num  = 1;
foreach ($logFile->getEntries() as $entry) {
    echo 'Line '.$num. ' '.$entry->getRequestQuery().'<br>';
    $num++;
}?>
        </div>
    </div>
</div>
