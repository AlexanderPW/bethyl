<?php

class Iis_parser extends CI_Model {

    public $fields;


    public function insert($data) {
        $this->load->database();
        $this->fields = $data;
        $this->db->insert('iis_logs', $this->fields);
    }

    public function update() {


    }

}

