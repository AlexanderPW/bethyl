<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product');
    }

    public function index()
    {
        $data = array('script' => array('<script src='.base_url().'assets/js/products.js></script>',
          '<script src='.base_url().'bower_components/datatables.net/js/jquery.dataTables.min.js></script>'
        ));
        $this->template->load('default', 'products', $data);
    }

    public function salesByYear() {
        $this->load->model('product');
        echo json_encode($this->product->getSalesBy3Years());
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
        $this->load->model('traffic');
        echo json_encode($this->traffic->getTop5CampaignsByMonth());
    }



    public function getDatatable()
    {
        $list = $this->product->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $products) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $products->material;
            $row[] = $products->ionet2;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->product->count_all(),
            "recordsFiltered" => $this->product->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
}
