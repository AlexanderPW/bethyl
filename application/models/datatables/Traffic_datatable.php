<?php

class Traffic_datatable extends CI_Model
{

    var $table = 'iis_logs';
    var $column_order = array(null, 'datetime', 'url', 'visiting_ip'); //set column field database for datatable orderable
    var $column_search = array('datetime', 'url', 'visiting_ip'); //set column field database for datatable searchable
    var $order = array('datetime' => 'desc'); // default order

    private function _get_datatables_query()
    {
        $date = date('Y-m-d 23:59:59', strtotime($_POST['date']));
        $fromDate = date('Y-m-d 00:00:00', strtotime("$date - 1 day"));
        $material = $_POST['id'];

        $this->db->select('datetime, url, visiting_ip');
        $this->db->from($this->table);


           $this->db->where("datetime >=", $fromDate);
           $this->db->where("datetime <=", $date);

        $this->db->like("url","$material");

        //Ordering
        if(isset($_POST['order']))
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


}