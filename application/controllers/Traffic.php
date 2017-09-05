<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Traffic extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product');
        $this->load->model('traffic_model');
    }

    public function index()
    {
        $data = array('script' => array('<script src='.base_url().'assets/js/traffic.js></script>',
          '<script src='.base_url().'bower_components/datatables.net/js/jquery.dataTables.min.js></script>',
            '<script src='.base_url().'bower_components/select2/dist/js/select2.js></script>'
          ));
        $this->template->load('default', 'traffic', $data);
    }

    public function trafficByMonth() {
        echo json_encode($this->traffic_model->getTrafficByMonth());
    }

    public function trafficLastWeek() {
        echo json_encode($this->traffic_model->getTrafficLastWeek());
    }

    public function productsByYear() {
        echo json_encode($this->product->getProductsByYear());
    }

    public function trafficCustom() {
        $this->load->model('product');
        $dateRange = array(
        'endD' => $this->input->get('end_range'),
        'startD' => $this->input->get('start_range')
    );
        echo json_encode($this->traffic_model->getTrafficCustom($dateRange));
    }

    public function getDatatable()
    {
        $list = $this->traffic_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $traffic) {
            $row = array();
            $row[] = $no;
            $row[] = date('M d, Y', strtotime($traffic->date));
            $row[] = ($traffic->url ? $traffic->url : '-');
            $row[] = ($traffic->campaign ? $traffic->campaign : '-');
            $row[] = ($traffic->ip ? $traffic->ip : '-');
            $row[] = ($traffic->customer ? $traffic->customer : '-');
            $data[] = $row;
            $no++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => '0',
            "recordsFiltered" => $this->traffic_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function getCustomers() {
        echo json_encode($this->traffic_model->getCustomers());
    }

    public function getReferrer() {
        echo json_encode($this->traffic_model->getReferrers());
    }

    public function getCampaign() {
        echo json_encode($this->traffic_model->getCampaigns());
    }

    public function getCode() {
        echo json_encode($this->traffic_model->getCodes());
    }

    public function getTime() {
        echo json_encode($this->traffic_model->getTimes());
    }
}
