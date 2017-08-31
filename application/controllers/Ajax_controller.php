<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_controller extends CI_Controller {


    public function getTrafficDatatable()
    {
        $this->load->model('datatables/traffic_datatable');
        $list = $this->traffic_datatable->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $date = $_POST['date'];
        $fromDate = date('Y-m-d', strtotime("$date - 1 day"));
        $material = $_POST['id'];
        foreach ($list as $traffic) {
            $row = array();
            $row[] = $no;
            $row[] = date('M d, Y', strtotime($traffic->datetime));
            $row[] = $traffic->url;
            $row[] = $traffic->visiting_ip;
            $data[] = $row;
            $no++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => '1',
            "recordsFiltered" => $this->traffic_datatable->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function gettest() {
        $table = $this->load->view('partials/traffic_modal', null, true);
        echo json_encode($table);
    }

}