<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function importIisDir() {
        $path = FCPATH."/upload/iis_logs";
        $this->load->library('file_iterator');
        $this->file_iterator->iterateIIS($path);
        echo 'all done';
    }

}