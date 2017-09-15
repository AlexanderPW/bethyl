<?php

class Settings extends CI_Model

{

    public function setSetting()
    {
        $data = array(
            'var' => $_POST['type'],
            'var2' => $_POST['val']
        );
        $this->db->where('var', $data['var']);
        $count = $this->db->count_all_results('config');

        if ($count) {
            $this->db->where('var', $data['var']);
            $this->db->update('config', $data);
        } else {
            $this->db->insert('config', $data);
        }
    }

    public function getLogLocations() {
        $this->db->select('var as type, var2 as value');
        $this->db->from('config');
        $this->db->like('var', '-location');
        $this->db->or_where('var', 'ssconvert');
        $results = $this->db->get();
        $arr = [];
        foreach ($results->result_array() as $array) {
            $arr[$array['type']] = $array['value'];
        }
        return $arr;
    }

    public function getTrafficOptions() {
        $this->db->select('var as type, var2 as value');
        $this->db->from('config');
        $this->db->where('var', 'trafficDays');
        $optVal = $this->db->get()->row();

        $select = '';
        $opGroup = array(
            '1' => 'One Day',
            '2' => 'Two Days',
            '3' => 'Three Days',
            '4' => 'Four Days',
            '5' => 'Five Days'
        );
        foreach($opGroup as $key => $val) {
            $select[] = "<option value='".$key."' ".($key == $optVal->value ? 'selected' : '').">".$val."</option>";
        }
        return $select;
    }

    public function getPath($type) {
        $this->db->where('var', $type);
        return $this->db->get('config')->row()->var2;
    }

    public function getSetting($type) {
        $this->db->where('var', $type);
        return $this->db->get('config')->row()->var2;
    }

    private function getLastTrafficId() {
        $result = $this->db->query("
        select x.id, max(x.date) from
        (select s.id, s.date, s.material, r.1day from sales s
        join traffic_relation r on
        s.id = r.`sales_id`
        where r.1day = 1 order by s.id desc)x;"
        );
        $row = $result->result_array();
        return $row[0]['id'];
    }

    public function getTrafficRelationData() {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', '900000');
            $this->db->select('id, date, material');
            $this->db->from('sales');
            $lastId = $this->getLastTrafficId();
            if($lastId) {
                $this->db->where('id >', $lastId);
            }
            $query = $this->db->get();
            $i = 0;
            while ($row = $query->unbuffered_row()) {
                     $this->setTrafficRelationData($row->id, $row->date, $row->material);
                     $i++;
                if($i == 100) {
                    sleep(5);
                    $i = 0;
                }
            }
    }

    public function setTrafficRelationData($id, $date, $material) {
        $this->load->model('product');
        $traffic = ($this->product->checkRelatedTraffic($date, $material) ? '1' : '0');
        $this->db->query("INSERT INTO `traffic_relation` (sales_id, 1day) VALUES ('".$id."', '".$traffic."')
        ON DUPLICATE KEY UPDATE 1day='".$traffic."';");
    }

}