<?php

class Csv_parser extends CI_Model {

    public $fields;


    public function insertReplaceKNA($path, $table)
    {
        $this->db->query(
            "LOAD DATA LOCAL INFILE '".$path."' 
            REPLACE INTO TABLE ".$table."
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\\n' 
            IGNORE 1 LINES
            (customer_number, name, name2, city, region, postalcode, street, address, class)
        ");

        $affectedRows = $this->db->affected_rows();
        return $affectedRows;
    }

}

