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
        $this->template->load('default', 'imports');
    }

    public function serverLog()
    {
        $targetDir  = FCPATH."upload/iis_logs/";
        $fileName   = $_FILES['file']['name'];
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            //insert file information into db table
           echo json_encode(array('blah' => 'blahblah', 'something' => '123'));
        }
    }
}
