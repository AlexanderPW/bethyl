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

}