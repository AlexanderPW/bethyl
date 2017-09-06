<?php


class Cron extends CI_Controller {

    public function importIisDir() {
        echo "Begin processing \n";
        $this->load->model('settings');
        $path = $this->settings->getPath('iis-location');
        $this->load->library('file_iterator');
        $this->file_iterator->iterateIIS($path);
    }

    public function getIisPath() {
        $this->load->model('settings');
        echo $this->settings->getPath('iis-location').'/*.log';
    }

    public function putIisPath() {
        echo FCPATH."upload/complete/iis_logs/";
    }

    public function getKnaPath() {
        $this->load->model('settings');
        echo $this->settings->getPath('kna-location').'/*.xlsx';
    }

    public function putKnaPath() {
        echo FCPATH."upload/complete/kna_logs/";
    }

    public function importKnaDir() {
        echo "Begin processing \n";
        $this->load->model('settings');
        $path = $this->settings->getPath('kna-location');
        $this->load->library('file_iterator');
        $this->file_iterator->iterateKNA($path);
        exit;
    }

    public function getMaraPath() {
        $this->load->model('settings');
        echo $this->settings->getPath('mara-location').'/*.xlsx';
    }

    public function putMaraPath() {
        echo FCPATH."upload/complete/mara_logs/";
    }

    public function importMaraDir() {
        echo "Begin processing \n";
        $this->load->model('settings');
        $path = $this->settings->getPath('mara-location');
        $this->load->library('file_iterator');
        $this->file_iterator->iterateMara($path);
        exit;
    }

    public function get901Path() {
        $this->load->model('settings');
        echo $this->settings->getPath('sales-location').'/*.xlsx';
    }

    public function put901Path() {
        echo FCPATH."upload/complete/901_logs/";
    }

    public function import901Dir() {
        echo "Begin processing \n";
        $this->load->model('settings');
        $path = $this->settings->getPath('sales-location');
        $this->load->library('file_iterator');
        $this->file_iterator->iterate901($path);
        exit;
    }

    public function getIpPath() {
        $this->load->model('settings');
        echo $this->settings->getPath('ip-location').'/*.xlsx';
    }

    public function putIpPath() {
        echo FCPATH."upload/complete/ip_logs/";
    }

    public function importIpDir() {
        echo "Begin processing \n";
        $this->load->model('settings');
        $path = $this->settings->getPath('ip-location');
        $this->load->library('file_iterator');
        $this->file_iterator->iterateIp($path);
        exit;
    }

}