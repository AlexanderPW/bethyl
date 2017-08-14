<?php


class Cron extends CI_Controller {

    public function importIisDir() {
        echo "Begin processing \n";
        $path = FCPATH."upload/iis_logs";
        $this->load->library('file_iterator');
        $this->file_iterator->iterateIIS($path);
    }

    public function importKnaDir() {
        echo "Begin processing \n";
        $path = FCPATH."upload/kna_logs/";
        $this->load->library('file_iterator');
        $this->file_iterator->iterateKNA($path);
        exit;
    }
}