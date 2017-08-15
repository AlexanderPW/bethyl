<?php
defined('BASEPATH') OR exit('No direct script access allowed');


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
                    'last_mara' => $this->getLastMara(),
                    'last_901' => $this->getLast901()
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

            private function getLast901() {
                $query = $this->db->query("SELECT * FROM `logs` WHERE action = '4' ORDER BY `id` DESC LIMIT 1");
                return $query->row();
            }

            public function serverLog()
            {
                $targetDir  = FCPATH."upload/iis_logs/";
                $fileName   = $_FILES['file']['name'];
                $targetFile = $targetDir . $fileName;
                $this->load->library('file_iterator');
                $count = 0;
                $fields = null;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    $count = $this->file_iterator->importIIS($fileName);
                }
                //response back to view
               echo json_encode(array('count' => $count, 'insert' => $count));
            }

            public function customerLog()
            {
                $targetDir  = FCPATH."upload/kna_logs/";
                $fileName   = $_FILES['file']['name'];
                $destination = FCPATH."upload/complete/kna_logs/".$fileName;
                $targetFile = $targetDir . $fileName;
                $this->load->library('file_iterator');
                $count = 0;
                $fields = null;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    exec("/usr/local/bin/ssconvert ".$targetFile." ".$targetFile.".csv 2>&1", $output);
                    $csvName = $fileName.'.csv';
                    $count = $this->file_iterator->importKNA($csvName, $targetDir);
                    $this->file_iterator->moveComplete($targetFile, $destination);
                }
                //response back to view
                echo json_encode(array('count' => $count, 'insert' => $count));
            }

            public function materialLog()
            {
                $targetDir  = FCPATH."upload/mara_logs/";
                $fileName   = $_FILES['file']['name'];
                $destination = FCPATH."upload/complete/mara_logs/".$fileName;
                $targetFile = $targetDir . $fileName;
                $this->load->library('file_iterator');
                $count = 0;
                $fields = null;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    exec("/usr/local/bin/ssconvert ".$targetFile." ".$targetFile.".csv 2>&1", $output);
                    $csvName = $fileName.'.csv';
                    $count = $this->file_iterator->importMara($csvName, $targetDir);
                    $this->file_iterator->moveComplete($targetFile, $destination);
                }
                //response back to view
                echo json_encode(array('count' => $count, 'insert' => $count));
            }

            public function salesLog()
            {
                $targetDir  = FCPATH."upload/901_logs/";
                $fileName   = $_FILES['file']['name'];
                $destination = FCPATH."upload/complete/901_logs/".$fileName;
                $targetFile = $targetDir . $fileName;
                $this->load->library('file_iterator');
                $count = 0;
                $fields = null;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    exec("/usr/local/bin/ssconvert ".$targetFile." ".$targetFile.".csv 2>&1", $output);
                    $csvName = $fileName.'.csv';
                    $count = $this->file_iterator->import901($csvName, $targetDir);
                    $this->file_iterator->moveComplete($targetFile, $destination);
                }
                //response back to view
                echo json_encode(array('count' => $count, 'insert' => $count));
            }
}




