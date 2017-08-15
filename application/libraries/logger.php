<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logger
{
const IIS_Log = 1;
const KNA_Log = 2;
const Mara_Log = 3;
const s901_Log = 4;

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

    public function KNAlog($fileName, $Records) {
        $fields = array(
            'action' => self::KNA_Log,
            'data' => $Records,
            'name' => $fileName
        );
        $this->ci->db->insert('logs', $fields);
    }

    public function Maralog($fileName, $Records) {
        $fields = array(
            'action' => self::Mara_Log,
            'data' => $Records,
            'name' => $fileName
        );
        $this->ci->db->insert('logs', $fields);
    }

    public function s901log($fileName, $Records) {
        $fields = array(
            'action' => self::s901_Log,
            'data' => $Records,
            'name' => $fileName
        );
        $this->ci->db->insert('logs', $fields);
    }

}

