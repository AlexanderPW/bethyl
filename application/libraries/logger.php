<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logger
{
const IIS_Log = 1;

    protected $path;

    var $ci;

    function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->database();
    }

    public function IISlog($fileName, $Records) {
        $fields = array(
            'action' => self::IIS_Log,
            'data' => $Records,
            'name' => $fileName
        );
        $this->ci->db->insert('logs', $fields);
    }

}

