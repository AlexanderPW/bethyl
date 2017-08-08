<?php

class Iis_parser extends CI_Model {

    public $fields;


    public function insert($data) {
        $this->fields = $data;
        $this->db->insert_batch('iis_logs', $this->fields);
    }

    public function update() {


    }

}

