<?php

class Iis_parser extends CI_Model {

    public $fields;

    public function insert($data) {
        $this->load->database();
        $this->fields = $data;
        $this->db->insert('iis_logs', $this->fields);
        $this->insertCampaignData($data);
        $this->insertCampaignSourceData($data);
        $this->insertCampaignMediumData($data);
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

    public function insertCampaignSourceData($data) {
        if(!empty($data['source'])) {
            $this->load->database();
            $date         = date('Y-m-01', strtotime($data['datetime']));
            $source     = $data['source'];
            $fields       = array(
                'date' => $date,
                'name' => $source
            );
            $this->fields = $data;
            $query = $this->db->insert_string('campaign_source', $fields);
            $query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $query);
            $this->db->query($query);
        }
    }

    public function insertCampaignMediumData($data) {
        if(!empty($data['medium'])) {
            $this->load->database();
            $date         = date('Y-m-01', strtotime($data['datetime']));
            $medium     = $data['medium'];
            $fields       = array(
                'date' => $date,
                'name' => $medium
            );
            $this->fields = $data;
            $query = $this->db->insert_string('campaign_medium', $fields);
            $query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $query);
            $this->db->query($query);
        }
    }

}

