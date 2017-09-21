<?php

class Product extends CI_Model
{

    public function getProducts() {
        $this->db->select('material AS id, material as text');
        $this->db->from('material');
        if (!empty($_GET['q'])) {
            $this->db->like('material', $_GET['q']);
        }
        $this->db->limit(10);

        $customers = $this->db->get();

        return $customers->result_array();
    }

    public function getGroups() {
        $this->db->distinct();
        $this->db->select('`group` AS id, `group` as text');
        $this->db->from('material');
        if (!empty($_GET['q'])) {
            $this->db->like('group', $_GET['q']);
        }
        $this->db->limit(10);

        $customers = $this->db->get();

        return $customers->result_array();
    }

    public function getSalesByMonth()
    {
        $results  = $this->db->query("
  SELECT DATE_FORMAT(date, '%M') AS label, qty as data, DATE_FORMAT(date, '%Y') AS year, DATE_FORMAT(date, '%Y-%m') AS sort
  from
  (
  select `date`, sum(billingqty) AS qty
  from sales
  WHERE date <= last_day(NOW())
    and date >= Date_add(date_format(Now(), '%Y-%m-01'),interval - 6 month)
    ".$this->getWhereClauses()."
  group by DATE_FORMAT(date, '%Y-%m')
  union all
  select last_day(NOW()), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01'),interval - 1 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01'),interval - 2 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01'),interval - 3 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01'),interval - 4 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01'),interval - 5 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01'),interval - 6 month), 0
) x
group by sort;");

        $results2 = $this->db->query("
  SELECT DATE_FORMAT(date, '%M') AS label, qty as data, DATE_FORMAT(date, '%Y') AS year, DATE_FORMAT(date, '%Y-%m') AS sort
  from
  (
  select `date`, sum(billingqty) AS qty
  from sales
  WHERE date <= last_day(NOW()) - interval 1 year
    and date >= Date_add(date_format(Now(), '%Y-%m-01') - interval 1 year,interval - 6 month)
    ".$this->getWhereClauses()."
  group by DATE_FORMAT(date, '%Y-%m')
  union all
  select last_day(NOW()) - interval 1 year, 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01') - interval 1 year,interval - 1 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01') - interval 1 year,interval - 2 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01') - interval 1 year,interval - 3 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01') - interval 1 year,interval - 4 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01') - interval 1 year,interval - 5 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01') - interval 1 year,interval - 6 month), 0
) x
group by sort;");

        $results3 = $this->db->query("SELECT DATE_FORMAT(date, '%Y-%m') AS sort, DATE_FORMAT(date, '%M') AS label, qty as data, DATE_FORMAT(date, '%Y') AS year
from
(
  select `date`, sum(billingqty) AS qty
  from sales
  WHERE date <= last_day(NOW()) - interval 2 year
    and date >= Date_add(date_format(Now(), '%Y-%m-01') - interval 2 year,interval - 6 month)
    ".$this->getWhereClauses()."
      group by DATE_FORMAT(date, '%Y-%m')
  union all
  select last_day(NOW()) - interval 2 year, 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01') - interval 2 year,interval - 1 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01') - interval 2 year,interval - 2 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01') - interval 2 year,interval - 3 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01') - interval 2 year,interval - 4 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01') - interval 2 year,interval - 5 month), 0
  union all
  select Date_add(date_format(Now(), '%Y-%m-01') - interval 2 year,interval - 6 month), 0
) x
group by sort;");

        $arr      = $results->result_array();
        $arr2     = $results2->result_array();
        $arr3     = $results3->result_array();

        return array($arr, $arr2, $arr3);

    }

    public function getProductsByYear() {
        $results = $this->db->query("
            SELECT DATE_FORMAT(date, '%M') AS label, qty as data, DATE_FORMAT(date, '%Y') AS year, DATE_FORMAT(date, '%Y-%m') AS sort
  from
  (
      select `date`, sum(billingqty) AS qty
  from sales
  WHERE date <= date_format(Now(), '%Y-12-31')
        and date >= date_format(Now(), '%Y-01-01')
            ".$this->getWhereClauses()."
  group by DATE_FORMAT(date, '%Y-%m')
  union all
  select date_format(Now(), '%Y-12-01'), 0
  union all
  select date_format(Now(), '%Y-11-01'), 0
  union all
  select date_format(Now(), '%Y-10-01'), 0
  union all
  select date_format(Now(), '%Y-09-01'), 0
  union all
  select date_format(Now(), '%Y-08-01'), 0
  union all
  select date_format(Now(), '%Y-07-01'), 0
  union all
  select date_format(Now(), '%Y-06-01'), 0
  union all
  select date_format(Now(), '%Y-05-01'), 0
  union all
  select date_format(Now(), '%Y-04-01'), 0
  union all
  select date_format(Now(), '%Y-03-01'), 0
  union all
  select date_format(Now(), '%Y-02-01'), 0
  union all
  select date_format(Now(), '%Y-01-01'), 0
) x
group by sort;"
        );

        $results2 = $this->db->query("
  SELECT DATE_FORMAT(date, '%M') AS label, qty as data, DATE_FORMAT(date, '%Y') AS year, DATE_FORMAT(date, '%Y-%m') AS sort
  from
  (
  select `date`, sum(billingqty) AS qty
  from sales
  WHERE date <= date_format(Now(), '%Y-12-31')- interval 1 year
  and date >= date_format(Now(), '%Y-01-01')- interval 1 year
      ".$this->getWhereClauses()."
  group by DATE_FORMAT(date, '%Y-%m')
  union all
  select date_format(Now(), '%Y-12-01')- interval 1 year, 0
  union all
  select date_format(Now(), '%Y-11-01')- interval 1 year, 0
  union all
  select date_format(Now(), '%Y-10-01')- interval 1 year, 0
  union all
  select date_format(Now(), '%Y-09-01')- interval 1 year, 0
  union all
  select date_format(Now(), '%Y-08-01')- interval 1 year, 0
  union all
  select date_format(Now(), '%Y-07-01')- interval 1 year, 0
  union all
  select date_format(Now(), '%Y-06-01')- interval 1 year, 0
  union all
  select date_format(Now(), '%Y-05-01')- interval 1 year, 0
  union all
  select date_format(Now(), '%Y-04-01')- interval 1 year, 0
  union all
  select date_format(Now(), '%Y-03-01')- interval 1 year, 0
  union all
  select date_format(Now(), '%Y-02-01')- interval 1 year, 0
  union all
  select date_format(Now(), '%Y-01-01')- interval 1 year, 0
) x
group by sort;"
        );

        $results3 = $this->db->query("
  SELECT DATE_FORMAT(date, '%M') AS label, qty as data, DATE_FORMAT(date, '%Y') AS year, DATE_FORMAT(date, '%Y-%m') AS sort
  from
  (
  select `date`, sum(billingqty) AS qty
  from sales
  WHERE date <= date_format(Now(), '%Y-12-31')- interval 2 year
  and date >= date_format(Now(), '%Y-01-01')- interval 2 year
      ".$this->getWhereClauses()."
  group by DATE_FORMAT(date, '%Y-%m')
  union all
  select date_format(Now(), '%Y-12-01')- interval 2 year, 0
  union all
  select date_format(Now(), '%Y-11-01')- interval 2 year, 0
  union all
  select date_format(Now(), '%Y-10-01')- interval 2 year, 0
  union all
  select date_format(Now(), '%Y-09-01')- interval 2 year, 0
  union all
  select date_format(Now(), '%Y-08-01')- interval 2 year, 0
  union all
  select date_format(Now(), '%Y-07-01')- interval 2 year, 0
  union all
  select date_format(Now(), '%Y-06-01')- interval 2 year, 0
  union all
  select date_format(Now(), '%Y-05-01')- interval 2 year, 0
  union all
  select date_format(Now(), '%Y-04-01')- interval 2 year, 0
  union all
  select date_format(Now(), '%Y-03-01')- interval 2 year, 0
  union all
  select date_format(Now(), '%Y-02-01')- interval 2 year, 0
  union all
  select date_format(Now(), '%Y-01-01')- interval 2 year, 0
) x
group by sort;"
        );

        $arr      = $results->result_array();
        $arr2     = $results2->result_array();
        $arr3     = $results3->result_array();

        return array($arr, $arr2, $arr3);

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
    ".$this->getWhereClauses()."
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
    ".$this->getWhereClauses()."
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
    ".$this->getWhereClauses()."
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
    select label, data, year 
    from
    (SELECT '".$dateRange['startD']." to ".$dateRange['endD']."' AS label, SUM(billingqty) as data, 'Custom Range' AS year
    FROM sales
    WHERE date >= '".$dateRange['startD']."'
    and date <= '".$dateRange['endD']."'
    ".$this->getWhereClauses()."
    GROUP BY label
    union all
    select '".$dateRange['startD']." to ".$dateRange['endD']."' as label, 0, 0
    ) x
    group by label;"
        );

        $results2 = $this->db->query("
    select label, data, year 
    from
    (SELECT '".$dateRange['startD']." to ".$dateRange['endD']."' AS label, SUM(billingqty) as data, '1 Year Historical' AS year
    FROM sales
    WHERE date >= date_sub('".$dateRange['startD']."', interval 1 year)
    and date <= date_sub('".$dateRange['endD']."', interval 1 year)
    ".$this->getWhereClauses()."
    GROUP BY label
    union all
    select '".$dateRange['startD']." to ".$dateRange['endD']."' as label, 0, 0
    ) x
    group by label;"
        );


        $results3 = $this->db->query("
    select label, data, year 
    from
    (SELECT '".$dateRange['startD']." to ".$dateRange['endD']."' AS label, SUM(billingqty) as data, '2 Years Historical' AS year
    FROM sales
    WHERE date >= date_sub('".$dateRange['startD']."', interval 2 year)
    and date <= date_sub('".$dateRange['endD']."', interval 2 year)
    ".$this->getWhereClauses()."
    GROUP BY label
    union all
    select '".$dateRange['startD']." to ".$dateRange['endD']."' as label, 0, 0
    ) x
    group by label;"
        );

        $arr      = $results->result_array();
        $arr2     = $results2->result_array();
        $arr3     = $results3->result_array();

        return array($arr, $arr2, $arr3);

    }

    public function checkRelatedTraffic($date, $material) {
       $dateFrom = date('Y-m-d', strtotime("$date - 1 day"));
       $results = $this->db->query("
select ifnull ((select id from iis_logs where datetime > '".$dateFrom." 00:00:00' and datetime < '".$date." 23:59:59'
and url like '%".$material."%' limit 1), 0) as traffic;"
       );

        $result = $results->row();
        return $result->traffic;
    }

    var $table = 'sales';
    var $column_order = array(null, 'sales.date', 'sales.material', 'sales.matlgroup', 'customer_logs.name', 'sales.billingqty', 'traffic_relation.one_day'); //set column field database for datatable orderable
    var $column_search = array('sales.date','sales.material', 'sales.billingqty'); //set column field database for datatable searchable
    var $order = array('date' => 'desc'); // default order

    private function _get_datatables_query()
    {

        $this->db->select('sales.date, sales.material, sales.matlgroup,  customer_logs.name, sales.billingqty, traffic_relation.one_day');
        $this->db->from($this->table);
        $this->db->join('customer_logs', 'customer_logs.customer_number = sales.soldtopt');
        $this->db->join('traffic_relation', 'sales.id = traffic_relation.sales_id', 'left');
        $this->db->where('sales.billingqty > 0');
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

        //Customer Field
        if(!empty($_POST['customer'])) {
            $this->db->where('customer_number =', $_POST['customer']);
        }

        //Product Field
        if(!empty($_POST['product'])) {
            $this->db->where('material =', $_POST['product']);
        }

        //Group Field
        if(!empty($_POST['group'])) {
            $this->db->where('matlgroup =', $_POST['group']);
        }

        //Trial Field
        if(!empty($_POST['trial'])) {
            $this->db->where("material like '%-T'");
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

    private function getWhereClauses(){
        $wheres = '';
        if(isset($_GET['customer']) && !empty($_GET['customer'])) {
            $wheres = "and soldtopt = '".$_GET['customer']."'";
        }
        if(isset($_GET['product']) && !empty($_GET['product'])) {
            $wheres .= "and material = '".$_GET['product']."'";
        }
        if(isset($_GET['group']) && !empty($_GET['group'])) {
            $wheres .= "and matlgroup = '" . $_GET['group'] . "'";
        }
        if(isset($_GET['dSearch']) && !empty($_GET['dSearch'])) {
            $wheres .= "and material like '%".$_GET['dSearch']."%'";
        }
        if(isset($_GET['trial']) && !empty($_GET['trial'])) {
            $wheres .= "and material like '%-T'";
        }
        return $wheres;
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