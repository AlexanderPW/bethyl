<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function index()
    {
        $this->template->load('default', 'entry');
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
}
