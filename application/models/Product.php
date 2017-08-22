<?php

class Product extends CI_Model
{

    public function getSalesBy3Years()
    {
        $results  = $this->db->query("
    SELECT DATE_FORMAT(date, '%M') AS label, SUM(netsales2) as data, DATE_FORMAT(date, '%Y') AS year
    FROM sales
    WHERE date <= NOW()
    and date >= Date_add(Now(),interval - 6 month)
    GROUP BY DATE_FORMAT(date, '%Y-%m');"
        );
        $results2 = $this->db->query("
    SELECT DATE_FORMAT(date, '%M') AS label, SUM(netsales2) as data, DATE_FORMAT(date, '%Y') AS year
    FROM sales
    WHERE date <= NOW() - interval 1 year
    and date >= Date_add(Now() - interval 1 year,interval - 6 month)
    GROUP BY DATE_FORMAT(date, '%Y-%m');"
        );
        $results3 = $this->db->query("
    SELECT DATE_FORMAT(date, '%M') AS label, SUM(netsales2) as data, DATE_FORMAT(date, '%Y') AS year
    FROM sales
    WHERE date <= NOW() - interval 2 year
    and date >= Date_add(Now() - interval 2 year,interval - 6 month)
    GROUP BY DATE_FORMAT(date, '%Y-%m');"
        );

        $arr      = $results->result_array();
        $arr2     = $results2->result_array();
        $arr3     = $results3->result_array();

        return array($arr, $arr2, $arr3);

    }




    var $table = 'customers';
    var $column_order = array(null, 'FirstName','LastName','phone','address','city','country'); //set column field database for datatable orderable
    var $column_search = array('FirstName','LastName','phone','address','city','country'); //set column field database for datatable searchable
    var $order = array('id' => 'asc'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {

        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
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