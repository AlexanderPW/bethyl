<?php


class Cron extends CI_Controller {

    public function importIisDir() {
        echo "Begin processing \n";
        $path = FCPATH."upload/iis_logs";
        $this->load->library('file_iterator');
        $this->file_iterator->iterateIIS($path);
    }

    public function getIisPath() {
        echo FCPATH."upload/iis_logs/*.log";
    }

    public function putIisPath() {
        echo FCPATH."upload/complete/iis_logs/";
    }

    public function getKnaPath() {
        echo FCPATH."upload/kna_logs/*.xlsx";
    }

    public function putKnaPath() {
        echo FCPATH."upload/complete/kna_logs/";
    }

    public function importKnaDir() {
        echo "Begin processing \n";
        $path = FCPATH."upload/kna_logs/";
        $this->load->library('file_iterator');
        $this->file_iterator->iterateKNA($path);
        exit;
    }

    public function getMaraPath() {
        echo FCPATH."upload/mara_logs/*.xlsx";
    }

    public function putMaraPath() {
        echo FCPATH."upload/complete/mara_logs/";
    }

    public function importMaraDir() {
        echo "Begin processing \n";
        $path = FCPATH."upload/mara_logs/";
        $this->load->library('file_iterator');
        $this->file_iterator->iterateMara($path);
        exit;
    }

    public function get901Path() {
        echo FCPATH."upload/901_logs/*.xlsx";
    }

    public function put901Path() {
        echo FCPATH."upload/complete/901_logs/";
    }

    public function import901Dir() {
        echo "Begin processing \n";
        $path = FCPATH."upload/901_logs/";
        $this->load->library('file_iterator');
        $this->file_iterator->iterate901($path);
        exit;
    }

    public function testParse() {

        $shit = 'referrer=Cell+Biology+Chromatin+Remodeling&target=RbBP7';
       echo  $this->GetBetween('campaign=', '&', $shit);
    }

    function GetBetween($var1="",$var2="",$pool){
        if(preg_match("/$var1/", $pool)) {
        $temp1 = strpos($pool,$var1)+strlen($var1);
        $result = substr($pool,$temp1,strlen($pool));
        $dd=strpos($result,$var2);
        if($dd == 0){
            $dd = strlen($result);
        }

        return substr($result,0,$dd);
        }
        return null;
    }
}