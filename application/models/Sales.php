<?php

class Sales extends CI_Model
{

    public function getSalesByYears()
    {
        $results  = $this->db->query("	select month, total from
	(SELECT DATE_FORMAT(date, '%Y-%m') AS month, SUM(netsales2) as total
    FROM sales
    WHERE date <= last_day(NOW())
    and date >= date_format(Now() - interval 1 year, '%Y-%m-01') 
    GROUP BY DATE_FORMAT(date, '%Y-%m') 
    union all
    select date_format(NOW(), '%Y-%m'), 0
    union all
    select date_format(NOW() - interval 1 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 2 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 3 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 4 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 5 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 6 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 7 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 8 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 9 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 10 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 11 month, '%Y-%m'), 0
    union all
    select date_format(NOW() - interval 12 month, '%Y-%m'), 0
    ) x
    group by month;
    ");

        $results2 = $this->db->query("	select month, total from
	(SELECT DATE_FORMAT(date, '%Y-%m') AS month, SUM(netsales2) as total
    FROM sales
    WHERE date <= last_day(NOW() - interval 1 year)
    and date >= date_format(Now() - interval 2 year, '%Y-%m-01') 
    GROUP BY DATE_FORMAT(date, '%Y-%m') 
    union all
    select date_format(NOW() - interval 1 year, '%Y-%m'), 0
    union all
    select date_format(NOW() - interval 13 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 14 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 15 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 16 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 17 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 18 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 19 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 20 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 21 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 22 month, '%Y-%m'), 0
	union all
    select date_format(NOW() - interval 23 month, '%Y-%m'), 0
    union all
    select date_format(NOW() - interval 24 month, '%Y-%m'), 0
    ) x
    group by month;
    ");

        $arr      = $results->result_array();
        $arr2     = $results2->result_array();
        $lineset  = [];
        $lineset2 = [];

        foreach ($arr as $val) {
            $lineset[] = array($val['month'] . '-01', (int)$val['total']);
        }
        foreach ($arr2 as $val) {
            $lineset2[] = array($val['month'] . '-01', (int)$val['total']);
        }
        return array($lineset, $lineset2);
    }


    public function getTop5ProductsByMonth()
    {
        $results = $this->db->query("select label, data from
(select ma.description as label, sa.material, sum(sa.billingqty) as data
from sales sa
join material ma on ma.`material` = sa.material
WHERE MONTH(sa.date) = MONTH(CURRENT_DATE())
AND YEAR(sa.date) = YEAR(CURRENT_DATE())
group by sa.material
Order by sum(billingqty) desc limit 5) x
union all 
(SELECT 'No Data', 0)
LIMIT 5;");

        $arr = $results->result_array();

        return $arr;
    }

    public function getTop5CustomersByMonth()
    {
        $results = $this->db->query("select label, data from
(select cu.name as label, sum(sa.netsales2) as data
from sales sa
join customer_logs cu on sa.soldtopt = cu.customer_number
WHERE MONTH(sa.date) = MONTH(CURRENT_DATE())
AND YEAR(sa.date) = YEAR(CURRENT_DATE())
group by sa.soldtopt
Order by sum(sa.netsales2) desc limit 5) x
union all
(SELECT 'No Data', 0)
LIMIT 5;");

        $arr = $results->result_array();

        return $arr;
    }

}