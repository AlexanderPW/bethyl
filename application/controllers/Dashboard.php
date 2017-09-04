<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function index()
    {
        $data = array(
            'script' => '<script src='.base_url().'assets/js/entry.js></script>'
        );
        $this->template->load('default', 'entry', $data);
    }

    public function salesByYear() {
        $this->load->model('sales');
        echo json_encode($this->sales->getSalesByYears());
    }

    public function top5ProductsMonth() {
        $this->load->model('sales');
        echo json_encode($this->sales->getTop5ProductsByMonth());
    }

    public function top5CustomersMonth() {
        $this->load->model('sales');
        echo json_encode($this->sales->getTop5CustomersByMonth());
    }

    public function top5CampaignsMonth() {
        $this->load->model('traffic_model');
        echo json_encode($this->traffic_model->getTop5CampaignsByMonth());
    }
}
