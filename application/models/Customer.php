<?php

class Customer extends CI_Model
{

    public function getSalesByMonth()
    {
        $results  = $this->db->query("
    SELECT DATE_FORMAT(date, '%M') AS label, SUM(billingqty) as data, DATE_FORMAT(date, '%Y') AS year
    FROM sales
    WHERE date <= last_day(NOW())
    and date >= Date_add(date_format(Now(), '%Y-%m-01'),interval - 6 month)
    GROUP BY DATE_FORMAT(date, '%Y-%m');"
        );
        $results2 = $this->db->query("
    SELECT DATE_FORMAT(date, '%M') AS label, SUM(billingqty) as data, DATE_FORMAT(date, '%Y') AS year
    FROM sales
    WHERE date <= last_day(NOW()) - interval 1 year
    and date >= Date_add(date_format(Now(), '%Y-%m-01') - interval 1 year,interval - 6 month)
    GROUP BY DATE_FORMAT(date, '%Y-%m');"
        );
        $results3 = $this->db->query("
    SELECT DATE_FORMAT(date, '%M') AS label, SUM(billingqty) as data, DATE_FORMAT(date, '%Y') AS year
    FROM sales
    WHERE date <= last_day(NOW()) - interval 2 year
    and date >= Date_add(date_format(Now(), '%Y-%m-01') - interval 2 year,interval - 6 month)
    GROUP BY DATE_FORMAT(date, '%Y-%m');"
        );

        $arr      = $results->result_array();
        $arr2     = $results2->result_array();
        $arr3     = $results3->result_array();

        return array($arr, $arr2, $arr3);

    }

    public function getCustomers(){

        $this->db->select('customer_number AS id, name as text');
        $this->db->from('customer_logs');
        if (!empty($_GET['q'])) {
            $this->db->like('name', $_GET['q']);
        }
        $this->db->limit(10);

        $customers = $this->db->get();

        return $customers->result_array();
    }

    public function getProductsLastWeek()
    {
        $results  = $this->db->query("select DATE_FORMAT(date, '%Y-%m-%d') as label, qty as data, 'Last Week' AS year
from
(
  select `date`, sum(billingqty) AS qty
  from sales
  WHERE date <= NOW()
    and date >= DATE_ADD(NOW(),INTERVAL -7 DAY)
  group by `date`
  union all
  select NOW(), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -1 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -2 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -3 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -4 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -5 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -6 DAY), 0
) x
group by label
order by label asc;"
        );
        $results2 = $this->db->query("select DATE_FORMAT(date, '%Y-%m-%d') as label, qty as data, '2 Weeks Historical' AS year
from
(
  select `date`, sum(billingqty) AS qty
  from sales
  WHERE date <= DATE_ADD(NOW(),INTERVAL -7 DAY)
    and date >= DATE_ADD(NOW(),INTERVAL -14 DAY)
  group by `date`
  union all
  select DATE_ADD(NOW(), INTERVAL -7 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -8 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -9 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -10 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -11 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -12 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -13 DAY), 0
) x
group by label
order by label asc;"
        );
        $results3 = $this->db->query("select DATE_FORMAT(date, '%Y-%m-%d') as label, qty as data, '3 Weeks Historical' AS year
from
(
  select `date`, sum(billingqty) AS qty
  from sales
  WHERE date <= DATE_ADD(NOW(),INTERVAL -14 DAY)
    and date >= DATE_ADD(NOW(),INTERVAL -21 DAY)
  group by `date`
  union all
  select DATE_ADD(NOW(), INTERVAL -14 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -15 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -16 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -17 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -18 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -19 DAY), 0
  union all
  select DATE_ADD(NOW(), INTERVAL -20 DAY), 0
) x
group by label
order by label asc;
"
        );

        $arr      = $results->result_array();
        $arr2     = $results2->result_array();
        $arr3     = $results3->result_array();

    foreach ($arr as &$val) {
        $val['label'] = date('l',strtotime($val['label']));
    }
        return array($arr, $arr2, $arr3);
    }

    public function getProductsCustom($dateRange)
    {
        $results  = $this->db->query("
SELECT 'Range ".$dateRange['endD']." to ".$dateRange['startD']."' AS label, SUM(billingqty) as data, DATE_FORMAT(date, '%Y') AS year
    FROM sales
    WHERE date <= '".$dateRange['startD']."'
    and date >= '".$dateRange['endD']."'
    GROUP BY label;"
        );
        $results2 = $this->db->query("
SELECT 'Range ".$dateRange['endD']." to ".$dateRange['startD']."' AS label, SUM(billingqty) as data, DATE_FORMAT(date, '%Y') AS year
    FROM sales
    WHERE date <= date_sub('".$dateRange['startD']."', interval 1 year)
    and date >= date_sub('".$dateRange['endD']."', interval 1 year)
    GROUP BY label;"
        );
        $results3 = $this->db->query("
SELECT 'Range ".$dateRange['endD']." to ".$dateRange['startD']."' AS label, SUM(billingqty) as data, DATE_FORMAT(date, '%Y') AS year
    FROM sales
    WHERE date <= date_sub('".$dateRange['startD']."', interval 2 year)
    and date >= date_sub('".$dateRange['endD']."', interval 2 year)
    GROUP BY label;"
        );

        $arr      = $results->result_array();
        $arr2     = $results2->result_array();
        $arr3     = $results3->result_array();

        return array($arr, $arr2, $arr3);

    }

    var $table = 'sales';
    var $column_order = array(null, 'date', 'material', 'billingqty'); //set column field database for datatable orderable
    var $column_search = array('date','material', 'billingqty'); //set column field database for datatable searchable
    var $order = array('date' => 'desc'); // default order

    private function _get_datatables_query()
    {

        $this->db->from($this->table);
        $i = 0;

        //Search Field
        foreach ($this->column_search as $item)
        {
            if($_POST['search']['value'])
            {

                if($i===0)
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        //Date Field
        if($_POST['start_range'] && $_POST['start_range']) {
            $this->db->where('date >=', $_POST['start_range']);
            $this->db->where('date <=', $_POST['end_range']);
        }

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