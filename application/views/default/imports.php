<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script src="<?=base_url();?>/bower_components/dropzone/dist/min/dropzone.min.js"></script>

<h3>Data Center</h3>
	<div class="row">
		<?
		//IIS
		$data['log_title'] = 'IIS Server Log Import';
		$data['mod_class'] = 'iis_import';
        $data['format'] = '.log';
        $data['url'] = 'serverlog';
        $data['last_time'] = date("F jS, Y", strtotime($recents['last_iis']->timestamp));
        $data['last_qty'] = $recents['last_iis']->data;
        $this->load->view('partials/file_importer', $data);
        $this->load->view('partials/file_uploader', $data);

        //KNA
		$data['log_title'] = 'KNA - Customer Import';
		$data['mod_class'] = 'kna_import';
        $data['format'] = '.pdf';
        $data['url'] = 'serverlog';
        $data['last_time'] = date("F jS, Y", strtotime($recents['last_kna']->timestamp));
        $data['last_qty'] = $recents['last_kna']->data;
        $this->load->view('partials/file_importer', $data);
        $this->load->view('partials/file_uploader', $data);

        //MARA
        $data['log_title'] = 'MARA - Material Import';
        $data['mod_class'] = 'mara_import';
        $data['format'] = 'xlsx';
        $data['url'] = 'serverlog';
        $data['last_time'] = date("F jS, Y", strtotime($recents['last_mara']->timestamp));
        $data['last_qty'] = $recents['last_mara']->data;
        $this->load->view('partials/file_importer', $data);
        $this->load->view('partials/file_uploader', $data);

        //S901
        $data['log_title'] = 'S901 - Sales Import';
        $data['mod_class'] = 's901_import';
        $data['format'] = 'xlsx';
        $data['url'] = 'serverlog';
        $this->load->view('partials/file_importer', $data);
        $this->load->view('partials/file_uploader', $data);
        ?>
	</div>






