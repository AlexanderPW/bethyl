<?php

class Kna_parser extends CI_Model {

    public $fields;


    public function insert($data) {
        $this->load->database();
        $this->fields = $data;
        $this->db->insert_batch('customer_logs', $this->fields);
    }

    public function update() {


    }

}

