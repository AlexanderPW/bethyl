<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product');
        $this->load->model('customer');
    }

    public function index()
    {
        $data = array('script' => array('<script src='.base_url().'assets/js/customers.js></script>',
          '<script src='.base_url().'bower_components/datatables.net/js/jquery.dataTables.min.js></script>',
            '<script src='.base_url().'bower_components/select2/dist/js/select2.js></script>'
          ));
        $this->template->load('default', 'customers', $data);
    }

    public function salesByMonth() {
        $this->load->model('customer');
        echo json_encode($this->customer->getSalesByMonth());
    }

    public function customersLastWeek() {
        $this->load->model('customer');
        echo json_encode($this->customer->getCustomersLastWeek());
    }

    public function customersByYear() {
        echo json_encode($this->customer->getCustomersByYear());
    }

    public function productsCustom() {
        $this->load->model('product');
        $dateRange = array(
        'endD' => $this->input->get('end_range'),
        'startD' => $this->input->get('start_range')
    );
        echo json_encode($this->product->getProductsCustom($dateRange));
    }

    public function getDatatable()
    {
        $list = $this->product->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $products) {
            $row = array();
            $row[] = $no;
            $row[] = date('M d, Y', strtotime($products->date));
            $row[] = $products->material;
            $row[] = $products->matlgroup;
            $row[] = $products->name;
            $row[] = $products->billingqty;
            $row[] = ($products->one_day
                ? "<a class='modal-toggle' data-toggle='modal' data-target='#myModal' data-id='".$products->material."' data-date='".$products->date."'>View Traffic</a>" :
                'Not Found');
            $data[] = $row;
            $no++;
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

    public function getCustomers() {
        $this->load->model('customer');
        echo json_encode($this->customer->getCustomers());
    }

    public function getProducts() {
        echo json_encode($this->product->getProducts());
    }
}
