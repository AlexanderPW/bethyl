<?php

class Iis_parser extends CI_Model {

    public $fields;

    public function insert($data) {
        $this->load->database();
        $this->fields = $data;
        $this->db->insert('iis_logs', $this->fields);
        $this->insertCampaignData($data);
    }

    public function insertCampaignData($data) {
        if(!empty($data['campaign'])) {
            $this->load->database();
            $date         = date('Y-m-01', strtotime($data['datetime']));
            $campaign     = $data['campaign'];
            $fields       = array(
                'date' => $date,
                'name' => $campaign
            );
            $this->fields = $data;
            $query = $this->db->insert_string('campaigns', $fields);
            $query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $query);
            $this->db->query($query);
        }
    }

}

