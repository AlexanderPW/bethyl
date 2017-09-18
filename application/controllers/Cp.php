<?php
defined('BASEPATH') OR exit('No direct script access allowed');


        class Cp extends CI_Controller
        {

            public function settings()
            {
                $data = array('script' => '<script src='.base_url().'assets/js/cp.js></script>',
                    'logLocations' => $this->getLogLocations(),
                    'trafficGroup' => $this->getTrafficOption());
                $this->template->load('default', 'settings', $data);
            }

            public function imports()
            {
                $data = array('recents' => $this->getUploadStatus());
                $this->template->load('default', 'imports', $data);
            }

            private function getUploadStatus()
            {
                return array(
                    'last_iis'  => $this->getLastIIS(),
                    'last_kna'  => $this->getLastKNA(),
                    'last_mara' => $this->getLastMara(),
                    'last_901'  => $this->getLast901(),
                    'last_ip'   => $this->getLastIP()
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

            private function getLastIP() {
                $query = $this->db->query("SELECT * FROM `logs` WHERE action = '5' ORDER BY `id` DESC LIMIT 1");
                return $query->row();
            }

            public function serverLog()
            {
                $this->load->model('settings');
                $targetDir  = $this->settings->getPath('iis-location');
                $fileName   = str_replace(' ', '_', $_FILES['file']['name']);
                $targetFile = $targetDir .'/'. $fileName;
                $this->load->library('file_iterator');
                $count = 0;
                $fields = null;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    $count = $this->file_iterator->importIIS($fileName);
                    $this->load->model('cron');
                    $this->cron->buildTrafficRelation();
                    $this->cron->buildTrafficRelationNull();
                }
                //response back to view
               echo json_encode(array('count' => $count, 'insert' => $count));
            }

            public function customerLog()
            {
                $this->load->model('settings');
                $targetDir  = $this->settings->getPath('kna-location');
                $fileName   = str_replace(' ', '_', $_FILES['file']['name']);
                $destination = FCPATH."upload/complete/kna_logs/".$fileName;
                $targetFile = $targetDir .'/'. $fileName;
                $this->load->library('file_iterator');
                $count = 0;
                $fields = null;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    exec($this->settings->getPath('ssconvert')." ".$targetFile." ".$targetFile.".csv 2>&1", $output);
                    $csvName = $fileName.'.csv';
                    $count = $this->file_iterator->importKNA($csvName, $targetDir);
                    $this->file_iterator->moveComplete($targetFile, $destination);
                }
                //response back to view
                echo json_encode(array('count' => $count, 'insert' => $count));
            }

            public function materialLog()
            {
                $this->load->model('settings');
                $targetDir  = $this->settings->getPath('mara-location');
                $fileName   = str_replace(' ', '_', $_FILES['file']['name']);
                $destination = FCPATH."upload/complete/mara_logs/".$fileName;
                $targetFile = $targetDir .'/'. $fileName;
                $this->load->library('file_iterator');
                $count = 0;
                $fields = null;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    exec($this->settings->getPath('ssconvert')." ".$targetFile." ".$targetFile.".csv 2>&1", $output);
                    $csvName = $fileName.'.csv';
                    $count = $this->file_iterator->importMara($csvName, $targetDir);
                    $this->file_iterator->moveComplete($targetFile, $destination);
                }
                //response back to view
                echo json_encode(array('count' => $count, 'insert' => $count));
            }

            public function salesLog()
            {
                $this->load->model('settings');
                $targetDir  = $this->settings->getPath('sales-location');
                $fileName   = str_replace(' ', '_', $_FILES['file']['name']);
                $destination = FCPATH."upload/complete/901_logs/".$fileName;
                $targetFile = $targetDir .'/'. $fileName;
                $this->load->library('file_iterator');
                $count = 0;
                $fields = null;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    exec($this->settings->getPath('ssconvert')." ".$targetFile." ".$targetFile.".csv 2>&1", $output);
                    $csvName = $fileName.'.csv';
                    $count = $this->file_iterator->import901($csvName, $targetDir);
                    $this->file_iterator->moveComplete($targetFile, $destination);
                    $this->load->model('cron');
                    $this->cron->buildTrafficRelation();
                    $this->cron->buildTrafficRelationNull();
                }
                //response back to view
                echo json_encode(array('count' => $count, 'insert' => $count));
            }

            public function ipLog()
            {
                $this->load->model('settings');
                $targetDir  = $this->settings->getPath('ip-location');
                $fileName   = str_replace(' ', '_', $_FILES['file']['name']);
                $destination = FCPATH."upload/complete/ip_logs/".$fileName;
                $targetFile = $targetDir .'/'. $fileName;
                $this->load->library('file_iterator');
                $count = 0;
                $fields = null;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    exec($this->settings->getPath('ssconvert')." ".$targetFile." ".$targetFile.".csv 2>&1", $output);
                    $csvName = $fileName.'.csv';
                    $count = $this->file_iterator->importIp($csvName, $targetDir);
                    $this->file_iterator->moveComplete($targetFile, $destination);
                }
                //response back to view
                echo json_encode(array('count' => $count, 'insert' => $count));
            }

            public function setSetting() {
                if($_POST['type'] && $_POST['val']) {
                    $this->load->model('settings');
                    $this->settings->setSetting();
                }
            }

            public function getLogLocations() {
                $this->load->model('settings');
                return $this->settings->getLogLocations();
            }

            public function getTrafficOption() {
                $this->load->model('settings');
                return $this->settings->getTrafficOptions();
            }
}




