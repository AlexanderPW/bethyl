<?php

class Traffic extends CI_Model
{

    public function getTop5CampaignsByMonth()
    {
        $results = $this->db->query("
SELECT campaign as label, count(*) as data
FROM traffic_logs
WHERE month(`datetime`) = month(current_date)
and campaign IS NOT NULL
group by campaign order by data desc limit 5"
        );

        $arr = $results->result_array();

        return array_reverse($arr);
    }


}