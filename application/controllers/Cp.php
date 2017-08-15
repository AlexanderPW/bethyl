<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Gumbercules\IisLogParser\LogFile;

class Cp extends CI_Controller
{

    public function settings()
    {
        $this->template->load('default', 'settings');
    }

    public function imports()
    {
        $data = array('recents' => $this->getUploadStatus());
        $this->template->load('default', 'imports', $data);
    }

    private function getUploadStatus() {
        return array(
            'last_iis' => $this->getLastIIS(),
            'last_kna' => $this->getLastKNA(),
            'last_mara' => $this->getLastMara()
        );
    }

    private function getLastIIS() {
        $query = $this->db->query("SELECT * FROM `logs` WHERE action = '1' ORDER BY `id` DESC LIMIT 1");
        return $query->row();
    }

    private function getLastKNA() {
        $query = $this->db->query("SELECT * FROM `logs` WHERE action = '2' ORDER BY `id` DESC LIMIT 1");
        return $query->row();
    }

    private function getLastMara() {
        $query = $this->db->query("SELECT * FROM `logs` WHERE action = '3' ORDER BY `id` DESC LIMIT 1");
        return $query->row();
    }

    public function serverLog()
    {
        $targetDir  = FCPATH."upload/iis_logs/";
        $fileName   = $_FILES['file']['name'];
        $targetFile = $targetDir . $fileName;
        $this->load->model('parsers/iis_parser');
        $fields = null;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            //insert file information into db table
            //create an instance of \SplFileObject to inject into LogFile
            $pathToFile = FCPATH."upload/iis_logs/".$fileName;
            $file = new \SplFileObject($pathToFile);

            //create instance of LogFile using \SplFileObject
            $logFile = new LogFile($file);

            //you will now have an array of LogEntry objects available via LogFile's getEntries() method
            $insert = 0;
            $this->load->database();
            ini_set('memory_limit', '512M');
            ini_set('max_execution_time', '900000');
            set_time_limit(0);
            foreach ($logFile->getEntries() as &$entry) {
                $fields[] = array(
                    'datetime' => $entry->getDateTime(),
                    'url' => $entry->getRequestUri(),
                    'variable' => $entry->getRequestQuery(),
                    'visiting_ip' => $entry->getClientIp(),
                    'agent' => $entry->getClientUserAgent(),
                    'response' => $entry->getResponseStatusCode(),
                    'time_taken' => $entry->getTimeTaken()
                );
 $insert++;
            }
            //insert array into db in chunks
        //   $this->iis_parser->insert($fields);
            //response back to view
           echo json_encode(array('count' => count($fields), 'insert' => $insert));
        }
    }
}




