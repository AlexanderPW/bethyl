<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Gumbercules\IisLogParser\LogFile;

class File_iterator
{

    var $ci;

    function __construct()
    {
        $this->ci =& get_instance();
    }

    public function iterateIIS($path)
    {
        $dir = new DirectoryIterator($path);
        foreach ($dir as $fileinfo) {
            $filename = $fileinfo->getFilename();
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if ($ext == 'log') {
              $this->importIIS($filename);
                gc_enable();
                gc_collect_cycles();
                exit;
            }
        }
    }

    public function importIIS($fileName)
    {
        $this->load->model('settings');
        $targetDir  = FCPATH.$this->settings->getPath('iis-location');
        $targetFile  = $targetDir.'/'.$fileName;
        $destination = FCPATH . "upload/complete/iis_logs/" . $fileName;
        $fields      = null;
        $this->ci->load->model('parsers/iis_parser');
        $this->ci->load->library('logger');
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', '900000');
        set_time_limit(0);

        if ($targetFile) {
            //insert file information into db table
            //create an instance of \SplFileObject to inject into LogFile
            $pathToFile = FCPATH . "upload/iis_logs/" . $fileName;
            $file       = new \SplFileObject($pathToFile);

            //create instance of LogFile using \SplFileObject

            $logFile = new LogFile($file);

            //you will now have an array of LogEntry objects available via LogFile's getEntries() method
            $insert = 0;

            foreach ($logFile->getEntries() as &$entry) {
                $variableParse = $entry->getRequestQuery();
                $fields = array(
                    'datetime'    => $entry->getDateTime(),
                    'url'         => $entry->getRequestUri(),
                    'variable'    => $variableParse,
                    'campaign'    => $this->GetBetween('utm_campaign=', '&', $variableParse),
                    'source'      => $this->GetBetween('utm_source=', '&', $variableParse),
                    'medium'      => $this->GetBetween('utm_medium=', '&', $variableParse),
                    'referrer'    => $this->GetBetween('referrer=', '&', $variableParse),
                    'target'      => $this->GetBetween('target=', '&', $variableParse),
                    'visiting_ip' => $entry->getClientIp(),
                    'agent'       => $entry->getClientUserAgent(),
                    'response'    => $entry->getResponseStatusCode(),
                    'time_taken'  => $entry->getTimeTaken()
                );
                $insert++;
                $this->ci->iis_parser->insert($fields);
            }

            $this->ci->logger->IISLog($fileName, $insert);
            $this->moveComplete($targetFile, $destination);
            $file    = null;
            $fields  = null;
            $logFile = null;
            gc_enable();
            gc_collect_cycles();
            sleep(7);
            return $insert;
        }
    }

    public function iterateKNA($path) {
        $dir = new DirectoryIterator($path);
        foreach ($dir as $fileinfo) {
            $fileName = $fileinfo->getFilename();
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            if ($ext == 'csv') {
                $this->importKNA($fileName, $path);
                exit;
            }
        }
    }

    public function importKNA($fileName, $path)
    {
        $table = 'customer_logs';
        $target = $path.'/'.$fileName;
        $destination = FCPATH . "upload/complete/kna_logs/" . $fileName;
        $this->ci->load->database();
        $this->ci->load->model('parsers/csv_parser');
        $count = $this->ci->csv_parser->insertReplaceKNA($target, $fileName, $table);
        $this->moveComplete($target, $destination);
        return $count;
    }

    public function iterateMara($path) {
        $dir = new DirectoryIterator($path);
        foreach ($dir as $fileinfo) {
            $fileName = $fileinfo->getFilename();
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            if ($ext == 'csv') {
                $this->importMara($fileName, $path);
                exit;
            }
        }
    }

    public function importMara($fileName, $path)
    {
        $table = 'material';
        $target = $path.'/'.$fileName;
        $destination = FCPATH . "upload/complete/mara_logs/" . $fileName;
        $this->ci->load->database();
        $this->ci->load->model('parsers/csv_parser');
        $count = $this->ci->csv_parser->insertReplaceMara($target, $fileName, $table);
        $this->moveComplete($target, $destination);
        return $count;
    }

    public function iterate901($path) {
        $dir = new DirectoryIterator($path);
        foreach ($dir as $fileinfo) {
            $fileName = $fileinfo->getFilename();
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            if ($ext == 'csv') {
                $this->import901($fileName, $path);
                exit;
            }
        }
    }

    public function import901($fileName, $path)
    {
        $table = 'sales';
        $target = $path.'/'.$fileName;
        $destination = FCPATH . "upload/complete/901_logs/" . $fileName;
        $this->ci->load->database();
        $this->ci->load->model('parsers/csv_parser');
        $count = $this->ci->csv_parser->insertReplace901($target, $fileName, $table);
        $this->moveComplete($target, $destination);
        return $count;
    }

    public function iterateIp($path) {
        $dir = new DirectoryIterator($path);
        foreach ($dir as $fileinfo) {
            $fileName = $fileinfo->getFilename();
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            if ($ext == 'csv') {
                $this->importIp($fileName, $path);
                exit;
            }
        }
    }

    public function importIp($fileName, $path)
    {
        $table = 'customer_ip';
        $target = $path.'/'.$fileName;
        $destination = FCPATH . "upload/complete/ip_logs/" . $fileName;
        $this->ci->load->database();
        $this->ci->load->model('parsers/csv_parser');
        $count = $this->ci->csv_parser->insertReplaceIp($target, $fileName, $table);
        $this->moveComplete($target, $destination);
        return $count;
    }

    public function moveComplete($from, $to) {
        rename($from, $to);
}

    public function GetBetween($var1="",$var2="",$pool){
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