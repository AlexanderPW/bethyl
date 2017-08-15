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
        $data['url'] = 'serverlog';
        $this->load->view('partials/file_importer', $data);
        $this->load->view('partials/file_uploader', $data);

        //KNA
		$data['log_title'] = 'KNA Customer Log Import';
		$data['mod_class'] = 'kna_import';
        $data['url'] = 'serverlog';
        $this->load->view('partials/file_importer', $data);
        $this->load->view('partials/file_uploader', $data);
        ?>
	</div>






