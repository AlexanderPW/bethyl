<?php

class Sales extends CI_Model
{

    public function getSalesByYears()
    {
        $results  = $this->db->query("
    SELECT DATE_FORMAT(date, '%Y-%m') AS month, SUM(netsales2) as total
    FROM sales
    WHERE date <= NOW()
    and date >= Date_add(Now(),interval - 12 month)
    GROUP BY DATE_FORMAT(date, '%Y-%m');"
        );
        $results2 = $this->db->query("
    SELECT DATE_FORMAT(date, '%Y-%m') AS month, SUM(netsales2) as total
    FROM sales
    WHERE date <= NOW() - interval 12 month
    and date >= Date_add(Now() - interval 12 month,interval - 12 month)
    GROUP BY DATE_FORMAT(date, '%Y-%m');"
        );

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
        $results = $this->db->query("
select ma.description as label, sa.material, sum(sa.billingqty) as data
from sales sa
join material ma on ma.`material` = sa.material
WHERE MONTH(sa.date) = MONTH(CURRENT_DATE())
AND YEAR(sa.date) = YEAR(CURRENT_DATE())
group by sa.material
Order by sum(billingqty) desc limit 5;"
        );

        $arr = $results->result_array();

        return $arr;
    }

    public function getTop5CustomersByMonth()
    {
        $results = $this->db->query("
    select cu.name as label, sum(sa.netsales2) as data
from sales sa
join customer_logs cu on sa.soldtopt = cu.customer_number
WHERE MONTH(sa.date) = MONTH(CURRENT_DATE())
AND YEAR(sa.date) = YEAR(CURRENT_DATE())
group by sa.soldtopt
Order by sum(sa.netsales2) desc limit 5;"
        );

        $arr = $results->result_array();

        return $arr;
    }

}