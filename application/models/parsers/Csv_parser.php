<?php

class Csv_parser extends CI_Model {

    public $fields;

    public function insertReplaceKNA($path, $fileName, $table)
    {
        $this->load->library('logger');
        $this->db->query(
            "LOAD DATA LOCAL INFILE '".$path."' 
            REPLACE INTO TABLE ".$table."
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\\n' 
            IGNORE 1 LINES
            (customer_number, name, name2, city, region, postalcode, street, address, class)
        ");
        $rowCount = $this->db->count_all($table);
        $this->logger->KNAlog($fileName, $rowCount);
        return $rowCount;
    }

    public function insertReplaceMara($path, $fileName, $table)
    {
        $this->load->library('logger');
        $this->db->query(
            "LOAD DATA LOCAL INFILE '".$path."' 
            REPLACE INTO TABLE ".$table."
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\\n' 
            IGNORE 1 LINES
            (`material`, `mtyp`, `group`, `bun`, `docver`, `description`, `gene_id`, `component`)
        ");
        $rowCount = $this->db->count_all($table);
        $this->logger->Maralog($fileName, $rowCount);
        return $rowCount;
    }

    public function insertReplace901($path, $fileName, $table)
    {
        $this->load->library('logger');
        $this->db->query(
            "LOAD DATA LOCAL INFILE '".$path."' 
            REPLACE INTO TABLE ".$table."
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\\n' 
            IGNORE 1 LINES
            (`date`, `usage`, `cospa`, `cl`, `soldtopt`, `shipto`, `matlgroup`, `material`, `bun`, `sales`,
            `billingqty`, `ionet1`, `ionet2`, `grinvsls`, `netsales1`, `netsales2`, `invfr`)
        ");
        $rowCount = $this->db->count_all($table);
        $this->logger->s901log($fileName, $rowCount);
        return $rowCount;
    }

    public function insertReplaceIp($path, $fileName, $table)
    {
        $this->load->library('logger');
        $this->db->query(
            "LOAD DATA LOCAL INFILE '".$path."' 
            REPLACE INTO TABLE ".$table."
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\\n' 
            IGNORE 1 LINES
            (`ip`, `customer`)
        ");
        $rowCount = $this->db->count_all($table);
        $this->logger->Iplog($fileName, $rowCount);
        return $rowCount;
    }

}

