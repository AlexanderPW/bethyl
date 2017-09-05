<?php

class Traffic_model extends CI_Model
{

    public function getReferrers() {
        $this->db->distinct();
        $this->db->select('referrer AS id, referrer as text');
        $this->db->from('iis_logs');
        if (!empty($_GET['term']) && !empty($_GET['start_range']) && !empty($_GET['end_range'])) {
            $this->db->where('datetime >=', $_GET['start_range'].' 00:00:00' );
            $this->db->where('datetime <=', $_GET['end_range'].' 23:59:59');
            $this->db->like('referrer', $_GET['term']);
        }
        $this->db->limit(10);

        $customers = $this->db->get();

        return $customers->result_array();
    }

    public function getCodes() {
        $this->db->distinct();
        $this->db->select('response AS id, response as text');
        $this->db->from('iis_logs');
        if (!empty($_GET['term']) && !empty($_GET['start_range']) && !empty($_GET['end_range'])) {
            $this->db->where('datetime >=', $_GET['start_range'].' 00:00:00' );
            $this->db->where('datetime <=', $_GET['end_range'].' 23:59:59');
            $this->db->like('response', $_GET['term']);
        }
        $this->db->limit(10);

        $customers = $this->db->get();

        return $customers->result_array();
    }

    public function getTimes() {
        $times = array(
            ['id' => '0 and 5', 'text' => '0 to 5ms'],
            ['id' => '5 and 10', 'text' => '5ms to 10ms'],
            ['id' => '10 and 20', 'text' => '10ms to 20ms'],
            ['id' => '20 and 50', 'text' => '20ms to 50ms'],
            ['id' => '50 and 75', 'text' => '50ms to 75ms'],
            ['id' => '75 and 100', 'text' => '75ms to 100ms'],
            ['id' => '100 and 250', 'text' => '100ms to 250ms'],
            ['id' => '250 and 500', 'text' => '250ms to 500ms'],
            ['id' => '500 and 1000', 'text' => '500ms to 1,000ms'],
            ['id' => '1000', 'text' => '1,000ms +']
        );

        return $times;
    }

    public function getCampaigns() {
        $this->db->distinct();
        $this->db->select('campaign AS id, campaign as text');
        $this->db->from('iis_logs');
        if (!empty($_GET['term']) && !empty($_GET['start_range']) && !empty($_GET['end_range'])) {
            $this->db->where('datetime >=', $_GET['start_range'].' 00:00:00' );
            $this->db->where('datetime <=', $_GET['end_range'].' 23:59:59');
            $this->db->like('campaign', $_GET['term']);
        }
        $this->db->limit(10);

        $customers = $this->db->get();

        return $customers->result_array();
    }

    public function getCustomers(){

        $this->db->distinct();
        $this->db->select('customer AS id, customer as text');
        $this->db->from('customer_ip');
        if (!empty($_GET['q'])) {
            $this->db->like('customer', $_GET['q']);
        }
        $this->db->limit(10);

        $customers = $this->db->get();

        return $customers->result_array();
    }

    public function getTrafficByMonth()
    {
        $results  = $this->db->query("SELECT DATE_FORMAT(datetime, '%M') AS label, qty as data, DATE_FORMAT(datetime, '%Y') AS year, DATE_FORMAT(datetime, '%Y-%m') AS sort
  from
  (
  select `datetime`, count(1) AS qty
  FROM iis_logs il
    LEFT JOIN customer_ip ci
    ON il.visiting_ip = ci.ip
  WHERE datetime <= last_day(date_format(NOW(), '%Y-%m-%d 23:59:59'))   
  and datetime >= date_format(Now(), '%Y-%m-01 00:00:00')
   ".$this->getWhereClauses()."
  group by DATE_FORMAT(datetime, '%Y-%m')
  union all
  select last_day(NOW()), 0
) x
group by label;
");

        $results2 = $this->db->query("SELECT DATE_FORMAT(datetime, '%M') AS label, qty as data, DATE_FORMAT(datetime, '%Y') AS year, DATE_FORMAT(datetime, '%Y-%m') AS sort
  from
  (
  select `datetime`, count(1) AS qty
  FROM iis_logs il
    LEFT JOIN customer_ip ci
    ON il.visiting_ip = ci.ip
  WHERE datetime <= last_day(date_format(NOW(), '%Y-%m-%d 23:59:59') - interval 1 year)   
  and datetime >= date_format(Now(), '%Y-%m-01 00:00:00') - interval 1 year
   ".$this->getWhereClauses()."
  group by DATE_FORMAT(datetime, '%Y-%m')
  union all
  select last_day(NOW()), 0
) x
group by label;
");

        $results3 = $this->db->query("SELECT DATE_FORMAT(datetime, '%M') AS label, qty as data, DATE_FORMAT(datetime, '%Y') AS year, DATE_FORMAT(datetime, '%Y-%m') AS sort
  from
  (
  select `datetime`, count(1) AS qty
  FROM iis_logs il
    LEFT JOIN customer_ip ci
    ON il.visiting_ip = ci.ip
  WHERE datetime <= last_day(date_format(NOW(), '%Y-%m-%d 23:59:59') - interval 2 year)   
  and datetime >= date_format(Now(), '%Y-%m-01 00:00:00') - interval 2 year
   ".$this->getWhereClauses()."
  group by DATE_FORMAT(datetime, '%Y-%m')
  union all
  select last_day(NOW()), 0
) x
group by label;
");

        $arr      = $results->result_array();
        $arr2     = $results2->result_array();
        $arr3     = $results3->result_array();

        return array($arr, $arr2, $arr3);

    }

    public function getTrafficLastWeek()
    {
        $results  = $this->db->query("select DATE_FORMAT(datetime, '%Y-%m-%d') as label, qty as data, 'Last Week' AS year
from
(
  select `datetime`, count(*) AS qty
    FROM iis_logs il
    LEFT JOIN customer_ip ci
    ON il.visiting_ip = ci.ip
  WHERE datetime <= date_format(NOW(), '%Y-%m-%d 23:59:59')
    and datetime >= DATE_ADD(date_format(NOW(), '%Y-%m-%d 00:00:00') ,INTERVAL -7 DAY)
    ".$this->getWhereClauses()."
  group by date_format(`datetime`, '&Y-%m-%d')
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
        $results2 = $this->db->query("select DATE_FORMAT(datetime, '%Y-%m-%d') as label, qty as data, '2 Weeks Historical' AS year
from
(
  select `datetime`, count(*) AS qty
  FROM iis_logs il
    LEFT JOIN customer_ip ci
    ON il.visiting_ip = ci.ip
  WHERE datetime <= DATE_ADD(date_format(NOW(), '%Y-%m-%d 23:59:59'),INTERVAL -7 DAY)
    and datetime >= DATE_ADD(date_format(NOW(), '%Y-%m-%d 00:00:00'),INTERVAL -14 DAY)
    ".$this->getWhereClauses()."
  group by date_format(`datetime`, '&Y-%m-%d')
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
        $results3 = $this->db->query("select DATE_FORMAT(datetime, '%Y-%m-%d') as label, qty as data, '3 weeks historical' AS year
from
(
  select `datetime`, count(*) AS qty
  FROM iis_logs il
    LEFT JOIN customer_ip ci
    ON il.visiting_ip = ci.ip
  WHERE datetime <= DATE_ADD(date_format(NOW(), '%Y-%m-%d 23:59:59'),INTERVAL -14 DAY)
    and datetime >= DATE_ADD(date_format(NOW(), '%Y-%m-%d 00:00:00'),INTERVAL -21 DAY)
    ".$this->getWhereClauses()."
  group by date_format(`datetime`, '&Y-%m-%d')
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
order by label asc;;
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

    public function getTrafficCustom($dateRange)
    {
        $results  = $this->db->query("
    select label, data, year 
    from
    (SELECT '".$dateRange['startD']." to ".$dateRange['endD']."' AS label, count(*) as data, 'Custom Range' AS year
    FROM iis_logs il
    LEFT JOIN customer_ip ci
    ON il.visiting_ip = ci.ip
    WHERE datetime >= date_format('".$dateRange['startD']."','%Y-%m-%d 00:00:00')
    and datetime <= date_format('".$dateRange['endD']."', '%Y-%m-%d 23:59:59')
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
    (SELECT '".$dateRange['startD']." to ".$dateRange['endD']."' AS label, count(*) as data, '1 Year Historical' AS year
    FROM iis_logs il
    LEFT JOIN customer_ip ci
    ON il.visiting_ip = ci.ip
    WHERE datetime >= date_format('".$dateRange['startD']."','%Y-%m-%d 00:00:00') - interval 1 year
    and datetime <= date_format('".$dateRange['endD']."', '%Y-%m-%d 23:59:59') - interval 1 year
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
    (SELECT '".$dateRange['startD']." to ".$dateRange['endD']."' AS label, count(*) as data, '2 Years Historical' AS year
    FROM iis_logs il
    LEFT JOIN customer_ip ci
    ON il.visiting_ip = ci.ip
    WHERE datetime >= date_format('".$dateRange['startD']."','%Y-%m-%d 00:00:00') - interval 2 year
    and datetime <= date_format('".$dateRange['endD']."', '%Y-%m-%d 23:59:59') - interval 2 year
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
select ifnull ((select id from traffic_logs where datetime > '".$dateFrom." 00:00:00' and datetime < '".$date." 23:59:59'
and url like '%".$material."%' limit 1), 0) as traffic;"
       );

        $result = $results->row();
        return $result->traffic;
    }

    var $table = 'iis_logs as il';
    var $column_order = array(null, 'date', 'url', 'campaign', 'ip', 'customer'); //set column field database for datatable orderable
    var $column_search = array('date', 'url', 'campaign', 'ip', 'customer'); //set column field database for datatable searchable
    var $order = array('date' => 'desc'); // default order

    private function _get_datatables_query()
    {

        $this->db->select("date_format(il.datetime, '%Y-%m-%d') as 'date', il.url as url, il.campaign as campaign, il.visiting_ip as ip, ci.customer as customer");
        $this->db->from($this->table);

        $this->db->join('customer_ip as ci', 'ci.ip = il.visiting_ip', 'left');
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
            $this->db->where('datetime >=', $_POST['start_range'].' 00:00:00');
            $this->db->where('datetime <=', $_POST['end_range'].' 23:59:59');
        }

        //Customer Field
        if(!empty($_POST['customer'])) {
            $this->db->like('customer', $_POST['customer']);
        }

        //Referrer Field
        if(!empty($_POST['referrer'])) {
            $this->db->where('il.referrer', $_POST['referrer']);
        }

        //Campaign Field
        if(!empty($_POST['campaign'])) {
            $this->db->where('il.campaign', $_POST['campaign']);
        }

        //Code Field
        if(!empty($_POST['code'])) {
            $this->db->where('il.response', $_POST['code']);
        }

        //Time Field
        if(!empty($_POST['time'])) {
            $time = $_POST['time'];
            $this->db->where("il.time_taken between $time");
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
            $wheres = "and ci.customer = '".$_GET['customer']."'";
        }
        if(isset($_GET['referrer']) && !empty($_GET['referrer'])) {
            $wheres .= "and referrer = '".$_GET['referrer']."'";
        }
        if(isset($_GET['campaign']) && !empty($_GET['campaign'])) {
            $wheres .= "and campaign = '".$_GET['campaign']."'";
        }
        if(isset($_GET['code']) && !empty($_GET['code'])) {
            $wheres .= "and response = '".$_GET['code']."'";
        }
        if(isset($_GET['time']) && !empty($_GET['time'])) {
            $time = $_GET['time'];
            $wheres .= "and time_taken between $time";
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

    public function getTop5CampaignsByMonth()
    {
        $results = $this->db->query("select `label`, `data` from
(SELECT campaign as label, count(*) as data
FROM iis_logs
WHERE (
datetime between  DATE_FORMAT(NOW() ,'%Y-%m-01')
AND NOW()
)
and campaign IS NOT NULL
group by campaign order by data desc limit 5
) x
union all
(SELECT 'No Data', 0) 
LIMIT 5;"
        );

        $arr = $results->result_array();

        return array_reverse($arr);
    }

}